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
    Schema::create('parent_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('registration_id')->constrained()->onDelete('cascade');
        $table->string('father_name');
        $table->string('father_occupation');
        $table->string('father_phone');
        $table->string('mother_name');
        $table->string('mother_occupation');
        $table->text('address');
        $table->timestamps();
    });
}
};
