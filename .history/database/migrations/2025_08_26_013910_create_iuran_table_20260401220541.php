<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iuran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penghuni_id');
            $table->string('bulan');
            $table->year('tahun');
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['lunas', 'belum'])->default('belum');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->foreign('penghuni_id')
                  ->references('id')
                  ->on('penghuni') // pastikan tabel penghuni juga singular
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iuran');
    }
};
