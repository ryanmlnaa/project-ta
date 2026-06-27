<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iuran', function (Blueprint $table) {
            $table->unsignedBigInteger('dibuat_oleh')->nullable()->after('id');
            $table->text('catatan_rt')->nullable()->after('dibuat_oleh');
            $table->unsignedBigInteger('rekap_id')->nullable()->after('catatan_rt');
        });

        // Perluas enum status iuran jadi 5 nilai
        DB::statement("ALTER TABLE iuran MODIFY COLUMN status ENUM('diajukan','ditolak','aktif','menunggu','lunas') NOT NULL DEFAULT 'diajukan'");
    }

    public function down(): void
    {
        Schema::table('iuran', function (Blueprint $table) {
            $table->dropColumn(['dibuat_oleh', 'catatan_rt', 'rekap_id']);
        });

        DB::statement("ALTER TABLE iuran MODIFY COLUMN status ENUM('belum','menunggu','lunas') NOT NULL DEFAULT 'belum'");
    }
};
