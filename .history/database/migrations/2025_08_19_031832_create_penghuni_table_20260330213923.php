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
        Schema::create('penghuni', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('no_ktp', 20)->unique();   // Nomor KTP / NIK
            $table->string('email', 100)->unique();
            $table->string('telepon', 20)->nullable();
            $table->string('alamat', 150);
            $table->string('blok_rumah', 10)->nullable();
            $table->string('no_rumah', 10)->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->enum('status_huni', ['Tetap', 'Kontrak'])->default('Tetap');
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};
