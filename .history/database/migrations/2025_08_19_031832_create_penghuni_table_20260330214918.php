<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {


        // =========================
        // TABEL PENGHUNI
        // =========================
       Schema::create('penghuni', function (Blueprint $table) {
    $table->id();
    $table->string('nama', 100);
    $table->string('no_ktp', 20)->unique();
    $table->string('email', 100)->unique();
    $table->string('telepon', 20)->nullable();
    $table->string('alamat', 150);

    // 🔥 RELASI
    $table->foreignId('rumah_id')
          ->nullable()
          ->constrained('rumah')
          ->onDelete('set null');

    $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
    $table->enum('status_huni', ['Tetap', 'Kontrak'])->default('Tetap');
    $table->date('tanggal_masuk')->nullable();
    $table->date('tanggal_keluar')->nullable();
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};
