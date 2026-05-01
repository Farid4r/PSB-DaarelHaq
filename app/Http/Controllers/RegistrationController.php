<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\ParentDetail;
use App\Models\Document;
use App\Models\Setting; // Pastikan ini terpanggil
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $registration = Registration::where('user_id', $user->id)
                        ->with('documents')
                        ->first();

        if (!$registration) {
            return redirect()->route('register.step1');
        }

        // Ambil pengaturan tahun ajaran untuk ditampilkan di view
        $academicYear = Setting::get('academic_year', '2026/2027');

        // --- LOGIKA PEMBAYARAN MIDTRANS ---
        if ($registration->status === 'pending' && empty($registration->snap_token)) {
            
            // AMBIL BIAYA DARI SETTING (Default ke 150000 jika kosong)
            $fee = (int) Setting::get('registration_fee', 150000);

            // Konfigurasi Midtrans (Sesuaikan dengan config/services.php atau config/midtrans.php milikmu)
            Config::$serverKey = config('midtrans.server_key') ?? config('services.midtrans.serverKey');
            Config::$isProduction = config('midtrans.is_production') ?? config('services.midtrans.isProduction');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $registration->registration_number . '-' . time(), 
                    'gross_amount' => $fee, // Menggunakan biaya dinamis dari dashboard admin
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $registration->snap_token = $snapToken;
            $registration->save();
        }

        return view('dashboard', compact('user', 'registration', 'academicYear'));
    }

    // --- STEP 1: Identitas Diri ---
    public function stepOne()
    {
        // LOGIKA GATEKEEPER: Cek apakah pendaftaran dibuka/ditutup
        if (Setting::get('is_registration_open') == '0') {
            return redirect()->route('dashboard')->with('error', 'Mohon maaf, pendaftaran santri baru saat ini sedang ditutup.');
        }

        return view('pendaftaran.step1'); 
    }

    public function postStepOne(Request $request)
    {
        $validated = $request->validate([
            'level' => 'required',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'full_name' => 'required|string|max:255',
            'nickname' => 'required|string|max:50',
            'child_order' => 'required|integer|min:1',
            'siblings_count' => 'required|integer|min:1',
            'kip_number' => 'nullable|string', 
            'previous_school_name' => 'required|string|max:255',
            'previous_school_address' => 'required|string',
            'nisn' => 'required|numeric|digits:10', 
        ]);

        Registration::updateOrCreate(
            ['user_id' => Auth::id()],
            array_merge($validated, [
                'registration_number' => Auth::user()->registration->registration_number ?? 'REG-' . strtoupper(uniqid())
            ])
        );

        return redirect()->route('register.step2');
    }

    // --- STEP 2: Data Orang Tua ---
    public function stepTwo()
    {
        $registration = Auth::user()->registration;
        if (!$registration) return redirect()->route('register.step1');

        $parent = $registration->parentDetail; 
        return view('pendaftaran.step2', compact('registration', 'parent'));
    }

    public function postStepTwo(Request $request)
    {
        $validated = $request->validate([
            'father_name' => 'required|string|max:255',
            'father_occupation' => 'required|string',
            'father_phone' => 'required|string',
            'mother_name' => 'required|string',
            'mother_occupation' => 'required|string',
            'address' => 'required|string',
        ]);

        $registration = Auth::user()->registration;

        ParentDetail::updateOrCreate(
            ['registration_id' => $registration->id],
            $validated
        );

        return redirect()->route('register.step3');
    }

    // --- STEP 3: Unggah Berkas ---
    public function stepThree()
    {
        $registration = Auth::user()->registration;
        if (!$registration) return redirect()->route('register.step1');

        $documents = $registration->documents->pluck('file_path', 'type')->toArray();
        
        return view('pendaftaran.step3', compact('registration', 'documents'));
    }

    public function postStepThree(Request $request)
    {
        $registration = Auth::user()->registration;

        $hasIjazah = $registration->documents()->where('type', 'ijazah')->exists();
        $hasKK = $registration->documents()->where('type', 'kk')->exists();
        $hasAkta = $registration->documents()->where('type', 'akta')->exists();
        $hasBpjs = $registration->documents()->where('type', 'bpjs')->exists();
        $hasKtp = $registration->documents()->where('type', 'ktp')->exists();
        $hasPasFoto = $registration->documents()->where('type', 'pas_foto')->exists();

        $request->validate([
            'ijazah' => ($hasIjazah ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'kk' => ($hasKK ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta' => ($hasAkta ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'bpjs' => ($hasBpjs ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp' => ($hasKtp ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'pas_foto' => ($hasPasFoto ? 'nullable' : 'required') . '|mimes:jpg,jpeg,png|max:2048',
        ]);

        $types = ['ijazah', 'kk', 'akta', 'bpjs', 'ktp', 'pas_foto'];

        foreach ($types as $type) {
            if ($request->hasFile($type)) {
                $oldDoc = Document::where('registration_id', $registration->id)->where('type', $type)->first();
                if ($oldDoc) {
                    Storage::disk('public')->delete($oldDoc->file_path);
                    $oldDoc->delete();
                }

                $path = $request->file($type)->store('documents/' . $registration->registration_number, 'public');
                
                Document::create([
                    'registration_id' => $registration->id,
                    'type' => $type,
                    'file_path' => $path
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Pendaftaran Anda telah kami terima.');
    }

    // --- CALLBACK MIDTRANS ---
    public function callback(Request $request)
    {
        Log::info('Webhook Midtrans Masuk:', $request->all());

        $serverKey = config('midtrans.server_key') ?? config('services.midtrans.serverKey');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $parts = explode('-', $request->order_id); 
                array_pop($parts); 
                $registrationNumber = implode('-', $parts);
                
                $registration = Registration::where('registration_number', $registrationNumber)->first();
                
                if ($registration) {
                    $registration->status = 'paid';
                    $registration->save();
                    Log::info("SUKSES: Pendaftaran " . $registrationNumber . " diubah jadi PAID");
                }
            }
        }
        
        return response()->json(['message' => 'Callback processed']);
    }

    public function cetakKartu()
    {
        $user = Auth::user();
        $registration = Registration::where('user_id', $user->id)
                        ->with(['parentDetail', 'documents'])
                        ->first();

        // --- LOGIKA BARU ---
        // Cek apakah santri ada, dan pastikan statusnya HANYA 'verified' atau 'accepted'
        if (!$registration || !in_array($registration->status, ['verified', 'accepted'])) {
            // Jika status masih 'pending', 'paid', atau 'rejected', kembalikan ke dashboard dengan pesan eror
            return redirect()->route('dashboard')->with('error', 'Mohon bersabar, Kartu Pendaftaran baru bisa dicetak setelah berkas divalidasi oleh Panitia.');
        }

        $pasFoto = $registration->documents->where('type', 'pas_foto')->first();
        $fotoPath = $pasFoto ? public_path('storage/' . $pasFoto->file_path) : null;

        // Siapkan data SETTING dinamis untuk PDF
        $data = [
            'registration' => $registration,
            'user' => $user,
            'fotoPath' => $fotoPath,
            'tanggalCetak' => \Carbon\Carbon::now()->translatedFormat('d F Y'),
            'academicYear' => Setting::get('academic_year', '2026/2027'),
            'headOfCommittee' => Setting::get('head_of_committee', 'Ketua Panitia PSB')
        ];

        $pdf = Pdf::loadView('pdf.kartu-pendaftaran', $data);
        $pdf->setPaper('A4', 'portrait'); 

        return $pdf->stream('Kartu_Pendaftaran_' . $registration->registration_number . '.pdf');
    }
}