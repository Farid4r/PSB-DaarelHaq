<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('full_name')->after('registration_number')->nullable();
            $table->string('nickname')->after('full_name')->nullable();
            $table->integer('child_order')->after('gender')->nullable();
            $table->integer('siblings_count')->after('child_order')->nullable();
            $table->string('kip_number')->after('siblings_count')->nullable();
            $table->string('previous_school_name')->after('kip_number')->nullable();
            $table->text('previous_school_address')->after('previous_school_name')->nullable();
            $table->string('nisn', 10)->after('previous_school_address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'full_name', 'nickname', 'child_order', 'siblings_count', 
                'kip_number', 'previous_school_name', 'previous_school_address', 'nisn'
            ]);
        });
    }
};