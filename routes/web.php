<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Rute Bebas Akses)
|--------------------------------------------------------------------------
| Rute di bawah ini bisa diakses oleh siapa saja tanpa perlu login.
*/
Route::get('/', function () {
    return view('welcome');
});

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

    // Profil User (Bawaan Laravel Breeze/UI)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ALUR PENDAFTARAN (MULTI-STEP) ---
    // Santri tidak akan bisa mengakses form ini jika emailnya belum diverifikasi
    Route::get('/register/step-1', [RegistrationController::class, 'stepOne'])->name('register.step1');
    Route::post('/register/step-1', [RegistrationController::class, 'postStepOne'])->name('register.step1.post');

    Route::get('/register/step-2', [RegistrationController::class, 'stepTwo'])->name('register.step2');
    Route::post('/register/step-2', [RegistrationController::class, 'postStepTwo'])->name('register.step2.post');

    Route::get('/register/step-3', [RegistrationController::class, 'stepThree'])->name('register.step3');
    Route::post('/register/step-3', [RegistrationController::class, 'postStepThree'])->name('register.step3.post');

});

/*
|--------------------------------------------------------------------------
| Admin Routes (Rute Khusus Panitia PSB)
|--------------------------------------------------------------------------
| Middleware 'admin' memastikan user memiliki role 'admin' atau 'super_admin'.
| Kita juga menambahkan 'verified' demi keamanan ekstra.
*/
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rute Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Manajemen Verifikasi Berkas Santri
    Route::get('/verifikasi/{id}', [AdminController::class, 'show'])->name('verifikasi');
    Route::post('/verifikasi/{id}/status', [AdminController::class, 'updateStatus'])->name('update.status');
    
    // Unduh Laporan
    Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('export.excel');

    // Pengaturan Sistem (Biaya, Tahun Ajaran, Buka/Tutup Pendaftaran)
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Manajemen Hak Akses Panitia
    Route::get('/manage-admins', [AdminController::class, 'manageAdmins'])->name('manage.admins');
    Route::post('/manage-admins/{id}/toggle', [AdminController::class, 'toggleRole'])->name('toggle.role');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Memanggil kumpulan rute login, register, dan verifikasi email bawaan Laravel.
*/
require __DIR__.'/auth.php';