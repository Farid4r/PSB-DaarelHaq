<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration; 
use App\Exports\RegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth; 
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengumumanHasilMail;

class AdminController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('user')->latest()->get();

        // --- PENYESUAIAN STATISTIK COUNTER SESUAI APPFLOW BARU ---
        $totalPendaftar = $registrations->count();
        
        // pending = santri baru upload berkas, menunggu admin periksa
        $menungguVerifikasi = $registrations->where('status', 'pending')->count(); 
        
        // verified = berkas sudah di-ACC admin, sekarang menunggu santri bayar di Midtrans
        $menungguPembayaran = $registrations->where('status', 'verified')->count(); 
        
        // paid = pembayaran lunas, accepted = lulus seleksi akhir pondok
        $lulus = $registrations->whereIn('status', ['paid', 'accepted'])->count();

        return view('admin.dashboard', compact(
            'registrations', 
            'totalPendaftar', 
            'menungguPembayaran', 
            'menungguVerifikasi', 
            'lulus'
        ));
    }

    public function show(string $id)
    {
        $registration = Registration::with(['user', 'parentDetail', 'documents'])->findOrFail($id);
        return view('admin.show', compact('registration'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,paid,verified,accepted,rejected', // Validasi strict sesuai ENUM DB
            'admin_note' => 'nullable|string'
        ]);

        $registration = Registration::findOrFail($id);
        
        $registration->status = $request->status;
        $registration->admin_note = $request->admin_note;
        $registration->save();

        // Kirim email pengumuman hasil akhir jika statusnya diterima/ditolak final dari pondok
        if (in_array($request->status, ['accepted', 'rejected']) && empty($request->admin_note)) {
            Mail::to($registration->user->email)->send(new PengumumanHasilMail($registration));
        }

        return redirect()->back()->with('success', 'Status pendaftaran dan catatan berhasil diperbarui!');
    }

    public function exportExcel()
    {
        if (Auth::user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Hanya Super Admin yang dapat mengunduh laporan.');
        }

        $namaFile = 'Rekap_Pendaftar_PSB_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new RegistrationsExport, $namaFile);
    }

    public function settings()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }

    public function manageAdmins()
    {
        $users = User::where('id', '!=', Auth::user()->id)
                     ->orderBy('name', 'asc')
                     ->get();

        return view('admin.manage-admins', compact('users'));
    }

    public function toggleRole(string $id)
    {
        $user = User::findOrFail($id);
        $user->role = ($user->role === 'admin') ? 'santri' : 'admin';
        $user->save();

        return redirect()->back()->with('success', 'Akses user ' . $user->name . ' berhasil diubah!');
    }
}