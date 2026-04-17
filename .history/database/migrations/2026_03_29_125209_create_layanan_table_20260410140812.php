<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('penghuni_id')
                ->constrained('penghuni')
                ->onDelete('cascade');

            $table->dateTime('tanggal_pengaduan');
            $table->string('kategori_masalah');
            $table->text('deskripsi');

            $table->string('foto')->nullable();

            $table->enum('status', ['diajukan', 'diproses', 'selesai'])
                ->default('diajukan');

            $table->text('tanggapan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
