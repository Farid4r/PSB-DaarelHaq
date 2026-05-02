<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Menampilkan daftar semua foto galeri.
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Menampilkan formulir tambah foto baru.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Menyimpan foto baru ke database dan folder storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Fasilitas,Kegiatan',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib ada foto saat tambah
        ]);

        $data = $request->all();

        // Menyimpan gambar ke folder storage/app/public/galleries
        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('galleries', 'public');
        }

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto berhasil ditambahkan ke galeri!');
    }

    /**
     * Menampilkan formulir edit data galeri.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Memperbarui informasi foto di database.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Fasilitas,Kegiatan',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional saat edit
        ]);

        $data = $request->all();

        // Jika admin mengunggah foto baru untuk mengganti yang lama
        if ($request->hasFile('image_path')) {
            // Hapus gambar lama
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            // Simpan gambar baru
            $data['image_path'] = $request->file('image_path')->store('galleries', 'public');
        } else {
            // Jika tidak ada file baru, kita hapus 'image_path' dari array data
            // agar database tidak menimpa foto lama dengan nilai kosong
            unset($data['image_path']);
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Data galeri berhasil diperbarui!');
    }

    /**
     * Menghapus foto dari database dan folder storage.
     */
    public function destroy(Gallery $gallery)
    {
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Foto berhasil dihapus dari galeri!');
    }
}