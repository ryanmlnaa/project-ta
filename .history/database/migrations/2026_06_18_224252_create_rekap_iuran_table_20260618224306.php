<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_iuran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bendahara_id');
            $table->unsignedBigInteger('rt_id');
            $table->string('periode'); // contoh: "Januari 2025"
            $table->enum('status', ['diajukan', 'ditolak', 'disetujui'])->default('diajukan');
            $table->text('catatan_rt')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_iuran');
    }
};
