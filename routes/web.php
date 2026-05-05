<?php

use Illuminate\Support\Facades\Route;

// Controller Utama
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;

// Controller Admin
use App\Http\Controllers\Admin\LeaderController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\GalleryController;

// === PENGGUNAAN ALIAS UNTUK MENCEGAH BENTROK ===
// Alias untuk Profil Akun (User/Santri)
use App\Http\Controllers\ProfileController as UserProfileController;
// Alias untuk Profil Lembaga (Admin)
use App\Http\Controllers\Admin\ProfileController as PondokProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes (Rute Bebas Akses)
|--------------------------------------------------------------------------
| Rute di bawah ini bisa diakses oleh siapa saja tanpa perlu login.
*/
// Rute Halaman Publik (Etalase)
Route::get('/', [FrontController::class, 'index'])->name('welcome');

// Rute untuk Publikasi Berita & Galeri
Route::get('/berita', [FrontController::class, 'berita'])->name('berita.index');
Route::get('/berita/{slug}', [FrontController::class, 'detailBerita'])->name('berita.show');
Route::get('/galeri', [FrontController::class, 'galeri'])->name('galeri.index');

// Webhook Midtrans harus publik agar server Midtrans bisa mengirim data ke aplikasi kita
Route::post('/midtrans/callback', [RegistrationController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Rute Khusus Santri)
|--------------------------------------------------------------------------
| Middleware 'auth' memastikan user sudah login.
| Middleware 'verified' memastikan user sudah mengklik link verifikasi di email.
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama Santri & Cetak Kartu
    Route::get('/dashboard', [RegistrationController::class, 'dashboard'])->name('dashboard');
    Route::get('/cetak-kartu', [RegistrationController::class, 'cetakKartu'])->name('cetak.kartu');

    // Profil User (Bawaan Laravel Breeze/UI) -> Menggunakan UserProfileController
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ALUR PENDAFTARAN (MULTI-STEP) ---
    Route::get('/register/step-1', [RegistrationController::class, 'stepOne'])->name('register.step1');
    Route::post('/register/step-1', [RegistrationController::class, 'postStepOne'])->name('register.step1.post');

    Route::get('/register/step-2', [RegistrationController::class, 'stepTwo'])->name('register.step2');
    Route::post('/register/step-2', [RegistrationController::class, 'postStepTwo'])->name('register.step2.post');

    Route::get('/register/step-3', [RegistrationController::class, 'stepThree'])->name('register.step3');
    Route::post('/register/step-3', [RegistrationController::class, 'postStepThree'])->name('register.step3.post');

});

/*
|--------------------------------------------------------------------------
| Admin & Super Admin Routes (Rute Khusus Panitia PSB)
|--------------------------------------------------------------------------
| Middleware 'admin' mengizinkan user dengan role 'admin' ATAU 'super_admin'.
*/
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // --- FITUR BERSAMA (Bisa diakses Admin & Super Admin) ---
    
    // Rute Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Manajemen Verifikasi Berkas Santri
    Route::get('/verifikasi/{id}', [AdminController::class, 'show'])->name('verifikasi');
    Route::post('/verifikasi/{id}/status', [AdminController::class, 'updateStatus'])->name('update.status');
    
    // Unduh Laporan
    Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('export.excel');

    // --- MANAJEMEN BERITA & GALERI ---
    // Rute ini kita tambahkan di sini agar Admin biasa bisa menulis berita
    Route::resource('posts', PostController::class);
    Route::resource('galleries', GalleryController::class);

    // Rute Profil Pondok (Teks Visi, Misi, dsb) -> Menggunakan PondokProfileController
    Route::get('/profil-pondok', [PondokProfileController::class, 'edit'])->name('profil.edit');
    Route::post('/profil-pondok', [PondokProfileController::class, 'update'])->name('profil.update');
        
    // Manajemen Data Pimpinan Pondok
    Route::resource('leaders', LeaderController::class);

    // --- FITUR KHUSUS SUPER ADMIN ---
    // Rute di bawah ini dilindungi lagi oleh middleware 'superadmin'
    Route::middleware(['superadmin'])->group(function () {
        
        // Pengaturan Sistem (Biaya, Tahun Ajaran, Buka/Tutup Pendaftaran)
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        
        // Manajemen Hak Akses Panitia
        Route::get('/manage-admins', [AdminController::class, 'manageAdmins'])->name('manage.admins');
        Route::post('/manage-admins/{id}/toggle', [AdminController::class, 'toggleRole'])->name('toggle.role');

  
    });
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Memanggil kumpulan rute login, register, dan verifikasi email bawaan Laravel.
*/
require __DIR__.'/auth.php';