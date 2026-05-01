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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('registration_number')->unique(); // Nomor Pendaftaran Otomatis
            $table->enum('level', ['SMP', 'SMA']); // Pilihan Jenjang

            // Biodata Singkat
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['L', 'P']);

            // Status Pendaftaran
            $table->enum('status', ['pending', 'paid', 'verified', 'accepted', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
