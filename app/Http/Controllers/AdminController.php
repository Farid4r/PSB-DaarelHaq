<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration; 
use App\Exports\RegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth; // <--- Tambahan untuk mengatasi error 'user'
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengumumanHasilMail;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua data pendaftaran beserta data user-nya, urutkan dari yang paling baru
        $registrations = Registration::with('user')->latest()->get();

        // Hitung statistik untuk ditampilkan di kartu atas
        $totalPendaftar = $registrations->count();
        $menungguPembayaran = $registrations->where('status', 'pending')->count();
        $menungguVerifikasi = $registrations->where('status', 'paid')->count();
        $lulus = $registrations->where('status', 'accepted')->count();

        // Kirim semua data ke halaman view admin.dashboard
        return view('admin.dashboard', compact(
            'registrations', 
            'totalPendaftar', 
            'menungguPembayaran', 
            'menungguVerifikasi', 
            'lulus'
        ));
    }

    // Menambahkan tipe 'string' pada $id agar VS Code Intelephense tidak protes
    public function show(string $id)
    {
        // Cari data pendaftaran berdasarkan ID, tarik juga data user, orang tua, dan dokumen
        $registration = Registration::with(['user', 'parentDetail', 'documents'])->findOrFail($id);
        
        return view('admin.show', compact('registration'));
    }

    // Menambahkan tipe 'string' pada $id
    public function updateStatus(Request $request, string $id)
    {
        // 1. Tambahkan validasi untuk admin_note
        $request->validate([
            'status' => 'required|string',
            'admin_note' => 'nullable|string' // Catatan boleh kosong
        ]);

        $registration = Registration::findOrFail($id);
        
        // 2. Simpan status dan catatan admin ke database
        $registration->status = $request->status;
        $registration->admin_note = $request->admin_note;
        $registration->save();

        // 3. Logika pengiriman email (tetap dipertahankan)
        if (in_array($request->status, ['accepted', 'rejected'])) {
            Mail::to($registration->user->email)->send(new PengumumanHasilMail($registration));
        }

        return redirect()->back()->with('success', 'Status pendaftaran dan catatan berhasil diperbarui!');
    }

    // Fungsi untuk mendownload Excel
    public function exportExcel()
    {
        // Menggunakan Facade Auth yang sudah di-import di atas
        if (Auth::user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Hanya Super Admin yang dapat mengunduh laporan.');
        }

        $namaFile = 'Rekap_Pendaftar_PSB_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new RegistrationsExport, $namaFile);
    }
    // Tambahkan di bagian atas:

    // ... di dalam class AdminController ...

    // 1. Tampilan Pengaturan Sistem
    public function settings()
    {
        // Ambil semua data setting dan jadikan array agar mudah dibaca di view
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    // 2. Simpan Pengaturan
    public function updateSettings(Request $request)
    {
        // Ambil semua input kecuali token CSRF
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }

    // 3. Tampilan Manajemen Panitia
    public function manageAdmins()
    {
        // Ambil semua user kecuali diri sendiri, urutkan berdasarkan nama
        $users = User::where('id', '!=', Auth::user()->id)
                     ->orderBy('name', 'asc')
                     ->get();

        return view('admin.manage-admins', compact('users'));
    }

    // 4. Ubah Role (Admin <=> Santri)
    // Tambahkan kata 'string' sebelum $id
    public function toggleRole(string $id)
    {
        $user = User::findOrFail($id);
        
        // Balikkan role: jika admin jadi santri, jika santri jadi admin
        $user->role = ($user->role === 'admin') ? 'santri' : 'admin';
        $user->save();

        return redirect()->back()->with('success', 'Akses user ' . $user->name . ' berhasil diubah!');
    }
}