<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('registration_id')->constrained()->onDelete('cascade');
        $table->string('type'); // Jenis berkas (Misal: ijazah, kk, akta)
        $table->string('file_path'); // Lokasi file di server
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
