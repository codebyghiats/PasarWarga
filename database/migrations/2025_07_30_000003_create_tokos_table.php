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
        Schema::create('tokos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_toko', 100);
            $table->text('deskripsi')->nullable();
            $table->string('lokasi', 150);
            $table->string('no_wa', 20)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->unique('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokos');
    }
};
