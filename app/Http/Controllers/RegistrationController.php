<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\ParentDetail;
use App\Models\Document;
use App\Models\Setting; 
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

        $academicYear = Setting::get('academic_year', '2026/2027');

        // --- LOGIKA PEMBAYARAN MIDTRANS ---
        if ($registration->status === 'paid' && empty($registration->snap_token)) {
            
            $fee = (int) Setting::get('registration_fee', 150000);

            Config::$serverKey = config('midtrans.server_key') ?? config('services.midtrans.serverKey') ?? env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = config('midtrans.is_production') ?? config('services.midtrans.isProduction') ?? env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => 'PAY-' . $registration->registration_number . 'T' . time(), 
                    'gross_amount' => $fee, 
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $registration->snap_token = $snapToken;
                $registration->save();
            } catch (\Exception $e) {
                Log::error('Midtrans Error: ' . $e->getMessage());
            }
        }

        return view('dashboard', compact('user', 'registration', 'academicYear'));
    }

    // --- STEP 1: Identitas Diri ---
    public function stepOne()
    {
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
            
            // FITUR BARU: Nomor Ijazah (dibuat nullable agar santri lulusan baru yang belum punya ijazah tetap bisa daftar)
            'nomor_ijazah' => 'nullable|string|max:255',
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
        $user = Auth::user();
        $registration = Registration::where('user_id', $user->id)->first();

        if (!$registration) {
            return redirect()->route('register.step1');
        }

        $isRevision = ($registration->status === 'rejected' && !empty($registration->admin_note));
        if ($registration->status !== 'pending' && !$isRevision) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak dapat mengubah berkas pada tahap ini.');
        }

        return view('pendaftaran.step3', compact('registration'));
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
        
        // FITUR BARU: Deteksi Transkrip Nilai
        $hasTranskrip = $registration->documents()->where('type', 'transkrip_nilai')->exists();

        $request->validate([
            'ijazah' => ($hasIjazah ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'kk' => ($hasKK ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta' => ($hasAkta ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'bpjs' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048', // FIX BUG: BPJS kembali opsional murni
            'ktp' => ($hasKtp ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
            'pas_foto' => ($hasPasFoto ? 'nullable' : 'required') . '|mimes:jpg,jpeg,png|max:2048',
            
            // FITUR BARU: Validasi Transkrip Nilai
            'transkrip_nilai' => ($hasTranskrip ? 'nullable' : 'required') . '|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // FITUR BARU: Menambahkan 'transkrip_nilai' ke dalam array pemroses unggahan
        $types = ['ijazah', 'kk', 'akta', 'bpjs', 'ktp', 'pas_foto', 'transkrip_nilai'];

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

        if ($registration->status === 'pending' || $registration->status === 'rejected') {
            $registration->status = 'pending';
            $registration->admin_note = null; 
            $registration->save();

            return redirect()->route('dashboard')->with('success', 'Berkas berhasil diajukan. Silakan tunggu proses verifikasi dari panitia.');
        }

        return redirect()->route('dashboard');
    }

    // --- CALLBACK MIDTRANS ---
    public function callback(Request $request)
    {
        Log::info('Webhook Midtrans Masuk:', $request->all());

        $serverKey = config('midtrans.server_key') ?? config('services.midtrans.serverKey') ?? env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed !== $request->signature_key) {
            Log::error("Signature key tidak cocok!");
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            
            $parts = explode('T', $request->order_id); 
            $orderClean = $parts[0];
            $registrationNumber = str_replace('PAY-', '', $orderClean);
            
            $registration = Registration::where('registration_number', $registrationNumber)->first();
            
            if ($registration) {
                $registration->status = 'verified';
                $registration->save();
                
                Log::info("SUKSES: Pendaftaran " . $registrationNumber . " Lunas, status menjadi VERIFIED.");
                return response()->json(['status' => 'success']);
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

        if (!$registration || !in_array($registration->status, ['verified', 'accepted'])) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda belum menyelesaikan pembayaran pendaftaran.');
        }

        $fotoBase64 = null;
        $pasFoto = $registration->documents->where('type', 'pas_foto')->first();
        if ($pasFoto && file_exists(public_path('storage/' . $pasFoto->file_path))) {
            $path = public_path('storage/' . $pasFoto->file_path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $dataImg = file_get_contents($path);
            $fotoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($dataImg);
        }

        $logoBase64 = null;
        $logoFullPath = public_path('assets/images/logo-ponpes.png');
        if (file_exists($logoFullPath)) {
            $type = pathinfo($logoFullPath, PATHINFO_EXTENSION);
            $dataImg = file_get_contents($logoFullPath);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($dataImg);
        }

        $data = [
            'registration'    => $registration,
            'user'            => $user,
            'fotoPath'        => $fotoBase64,
            'logoPath'        => $logoBase64, 
            'tanggalCetak'    => \Carbon\Carbon::now()->translatedFormat('d F Y'),
            'academicYear'    => Setting::get('academic_year', '2026/2027'),
            'headOfCommittee' => Setting::get('head_of_committee', 'Ketua Panitia PSB')
        ];

        $pdf = Pdf::loadView('pdf.kartu-pendaftaran', $data);
        $pdf->setPaper('A4', 'portrait'); 

        return $pdf->stream('Kartu_Pendaftaran_' . $registration->registration_number . '.pdf');
    }
}