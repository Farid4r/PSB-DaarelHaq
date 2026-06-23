<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Menambahkan kolom nomor_ijazah tepat setelah kolom nisn
            $table->string('nomor_ijazah')->nullable()->after('nisn');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('nomor_ijazah');
        });
    }
};