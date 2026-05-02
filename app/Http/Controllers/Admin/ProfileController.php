<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; // Pastikan Model Setting sudah dibuat sebelumnya

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman formulir untuk edit profil pondok.
     */
    public function edit()
    {
        // Mengambil data dari tabel settings berdasarkan kolom 'key'
        // Jika data tidak ditemukan, kita berikan nilai default berupa string kosong ('')
        $tentangKami = Setting::where('key', 'tentang_kami')->value('value') ?? '';
        $visi = Setting::where('key', 'visi')->value('value') ?? '';
        $misi = Setting::where('key', 'misi')->value('value') ?? '';

        // Mengirimkan variabel ke file view resources/views/admin/profil/edit.blade.php
        return view('admin.profil.edit', compact('tentangKami', 'visi', 'misi'));
    }

    /**
     * Menyimpan atau memperbarui data profil ke dalam database.
     */
    public function update(Request $request)
    {
        // 1. Validasi Input: Memastikan semua kolom wajib diisi
        $request->validate([
            'tentang_kami' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        // 2. Simpan Data menggunakan updateOrCreate
        // Parameter pertama: Kriteria pencarian (key)
        // Parameter kedua: Data yang ingin disimpan/diubah (value)
        Setting::updateOrCreate(['key' => 'tentang_kami'], ['value' => $request->tentang_kami]);
        Setting::updateOrCreate(['key' => 'visi'], ['value' => $request->visi]);
        Setting::updateOrCreate(['key' => 'misi'], ['value' => $request->misi]);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Profil Pondok Pesantren berhasil diperbarui!');
    }
}