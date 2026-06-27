<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_bendahara', function (Blueprint $table) {
            $table->unsignedBigInteger('penghuni_id')->nullable()->after('rt_id');
            $table->enum('status', ['manual', 'menunggu_bayar', 'menunggu_konfirmasi', 'lunas'])->default('manual')->after('keterangan');
            $table->string('metode')->nullable()->after('status');
            $table->string('bukti_pembayaran')->nullable()->after('metode');
        });
    }

    public function down(): void
    {
        Schema::table('kas_bendahara', function (Blueprint $table) {
            $table->dropColumn(['penghuni_id', 'status', 'metode', 'bukti_pembayaran']);
        });
    }
};
