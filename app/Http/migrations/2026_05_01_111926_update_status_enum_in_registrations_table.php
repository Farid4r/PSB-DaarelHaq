<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; // Pastikan ini ditambahkan

return new class extends Migration
{
    /**
     * Jalankan perintah untuk mengubah database.
     */
    public function up(): void
    {
        // Memperbarui daftar ENUM dengan menambahkan 'revision'
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM('pending', 'paid', 'verified', 'revision', 'accepted', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Batalkan perintah (Rollback).
     */
    public function down(): void
    {
        // Mengembalikan daftar ENUM seperti semula (tanpa 'revision')
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM('pending', 'paid', 'verified', 'accepted', 'rejected') DEFAULT 'pending'");
    }
};