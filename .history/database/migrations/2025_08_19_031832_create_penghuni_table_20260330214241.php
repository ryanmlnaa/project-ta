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

            // ❌ HAPUS INI (sudah tidak dipakai)
            // $table->string('blok_rumah', 10)->nullable();
            // $table->string('no_rumah', 10)->nullable();

            // 🔥 TAMBAHAN RELASI
            $table->foreignId('rumah_id')->nullable()->constrained('rumah');

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
        Schema::dropIfExists('rumah');
    }
};
