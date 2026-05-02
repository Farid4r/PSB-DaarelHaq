<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Leader;
use App\Models\Post;    // Tambahkan Model Berita
use App\Models\Gallery; // Tambahkan Model Galeri

class FrontController extends Controller
{
    /**
     * Menampilkan halaman beranda utama (Welcome).
     */
    public function index()
    {
        $tentangKami = Setting::where('key', 'tentang_kami')->value('value');
        $visi = Setting::where('key', 'visi')->value('value');
        $misi = Setting::where('key', 'misi')->value('value');
        $leaders = Leader::all();

        return view('welcome', compact('tentangKami', 'visi', 'misi', 'leaders'));
    }

    /**
     * Menampilkan daftar berita untuk publik.
     */
    public function berita()
    {
        // Mengambil berita yang statusnya 'publish', diurutkan dari terbaru
        // paginate(6) artinya kita hanya menampilkan maksimal 6 berita per halaman
        $posts = Post::where('status', 'publish')->latest()->paginate(6);
        return view('berita.index', compact('posts'));
    }

    /**
     * Menampilkan isi lengkap / detail sebuah berita.
     */
    public function detailBerita(string $slug)
    {
        // Mencari berita berdasarkan slug (URL), dan pastikan statusnya 'publish'
        // firstOrFail() akan memunculkan halaman 404 jika berita tidak ditemukan
        $post = Post::where('slug', $slug)->where('status', 'publish')->firstOrFail();
        return view('berita.show', compact('post'));
    }

    /**
     * Menampilkan seluruh foto galeri untuk publik.
     */
    public function galeri()
    {
        // Mengambil semua foto galeri dari terbaru
        $galleries = Gallery::latest()->get();
        return view('galeri.index', compact('galleries'));
    }
}