<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Menambahkan kolom admin_note bertipe text. 
            // nullable() berarti kolom ini boleh kosong (karena santri yang berkasnya valid tidak butuh catatan).
            $table->text('admin_note')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('admin_note');
        });
    }
};