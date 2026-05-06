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
            $table->unsignedBigInteger('rt_id'); // 🔥 WAJIB

            $table->string('bulan');
            $table->year('tahun');
            $table->decimal('jumlah', 12, 2);

            $table->string('jenis_iuran')->nullable();
            $table->text('keterangan')->nullable();

            $table->enum('status', ['belum', 'menunggu', 'lunas'])->default('belum');
            $table->date('tanggal_bayar')->nullable();

            $table->string('bukti_pembayaran')->nullable();

            $table->timestamps();

            // RELASI
            $table->foreign('penghuni_id')
                ->references('id')
                ->on('penghuni')
                ->onDelete('cascade');

            $table->foreign('rt_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iuran');
    }
};
