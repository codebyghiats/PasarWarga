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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategoris')->nullOnDelete();
            $table->string('nama_produk', 100);
            $table->text('deskripsi')->nullable();
            $table->integer('harga');
            $table->integer('stok')->default(0);
            $table->string('foto', 255)->nullable();
            $table->timestamps();

            $table->index('kategori_id');
            $table->index('nama_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
