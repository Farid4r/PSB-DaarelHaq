<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk menghapus gambar lama

class LeaderController extends Controller
{
    /**
     * 1. Menampilkan daftar semua pimpinan.
     */
    public function index()
    {
        // Mengambil semua data pimpinan dari database
        $leaders = Leader::all();
        return view('admin.leaders.index', compact('leaders'));
    }

    /**
     * 2. Menampilkan formulir untuk tambah pimpinan baru.
     */
    public function create()
    {
        return view('admin.leaders.create');
    }

    /**
     * 3. Menyimpan data pimpinan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        // Logika untuk menyimpan file foto jika admin mengunggahnya
        if ($request->hasFile('photo')) {
            // Menyimpan gambar ke folder storage/app/public/leaders
            $path = $request->file('photo')->store('leaders', 'public');
            $data['photo'] = $path;
        }

        Leader::create($data);

        return redirect()->route('admin.leaders.index')->with('success', 'Data pimpinan berhasil ditambahkan!');
    }

    /**
     * 4. Menampilkan formulir untuk mengedit data pimpinan.
     */
    public function edit(Leader $leader)
    {
        return view('admin.leaders.edit', compact('leader'));
    }

    /**
     * 5. Memperbarui data pimpinan di database.
     */
    public function update(Request $request, Leader $leader)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        // Jika admin mengunggah foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($leader->photo) {
                Storage::disk('public')->delete($leader->photo);
            }
            // Simpan foto baru
            $path = $request->file('photo')->store('leaders', 'public');
            $data['photo'] = $path;
        }

        $leader->update($data);

        return redirect()->route('admin.leaders.index')->with('success', 'Data pimpinan berhasil diperbarui!');
    }

    /**
     * 6. Menghapus data pimpinan dari database.
     */
    public function destroy(Leader $leader)
    {
        // Hapus file foto dari folder (jika ada) sebelum menghapus data di database
        if ($leader->photo) {
            Storage::disk('public')->delete($leader->photo);
        }
        
        $leader->delete();

        return redirect()->route('admin.leaders.index')->with('success', 'Data pimpinan berhasil dihapus!');
    }
}