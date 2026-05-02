<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Fungsi wajib untuk membuat slug otomatis

class PostController extends Controller
{
/**
     * Menampilkan daftar semua berita.
     */
    public function index()
    {
        // Mengambil berita, diurutkan dari yang terbaru (latest)
        $posts = Post::latest()->get();
        
        // PERBAIKAN: Pastikan menggunakan 'posts' (dengan huruf s), sesuai dengan nama variabel di atasnya
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Menampilkan formulir tambah berita.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,publish'
        ]);

        $data = $request->all();
        
        // Mengubah judul menjadi format URL ramah SEO
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir edit berita.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Memperbarui berita di database.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,publish'
        ]);

        $data = $request->all();
        
        // Memperbarui slug jika admin mengubah judulnya
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus!');
    }
}