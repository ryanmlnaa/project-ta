<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_bendahara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bendahara_id');
            $table->unsignedBigInteger('rt_id');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->bigInteger('jumlah');
            $table->string('keterangan');
            $table->unsignedBigInteger('iuran_id')->nullable(); // otomatis dari pembayaran
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_bendahara');
    }
};
