<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =========================
        // TABEL RUMAH
        // =========================
        Schema::create('rumah', function (Blueprint $table) {
            $table->id();
            $table->string('blok');
            $table->string('no_rumah');
            $table->enum('status', ['Kosong', 'Terisi'])->default('Kosong');
            $table->integer('luas_tanah')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->string('gambar')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    
    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni');
        Schema::dropIfExists('rumah');
    }
};
