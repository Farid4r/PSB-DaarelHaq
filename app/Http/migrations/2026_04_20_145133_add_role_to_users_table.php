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
        Schema::table('users', function (Blueprint $table) {
            // Mengecek apakah kolom 'role' sudah ada sebelum membuatnya
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('santri')->after('email');
            }
        });
    }

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
};
