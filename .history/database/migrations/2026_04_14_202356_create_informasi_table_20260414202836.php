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
    Schema::create('informasi', function (Blueprint $table) {
        $table->id();

        $table->string('judul');
        $table->text('isi');

        $table->date('tanggal');

        $table->string('kategori')->default('Umum');
        $table->string('penulis')->nullable();

        $table->string('gambar')->nullable();

        $table->boolean('is_penting')->default(false);
        $table->integer('views')->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi');
    }
};
