<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perintah untuk membuat tabel.
     */
    public function up(): void
    {
        // Mengecek apakah tabel sudah ada agar tidak terjadi eror ganda
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary(); // Email digunakan sebagai kunci utama
                $table->string('token'); // Tempat menyimpan kode rahasia
                $table->timestamp('created_at')->nullable(); // Waktu permintaan reset
            });
        }
    }

    /**
     * Batalkan perintah (Rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};