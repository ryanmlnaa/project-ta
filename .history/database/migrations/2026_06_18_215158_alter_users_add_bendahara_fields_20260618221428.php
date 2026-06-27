<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom rt_id dan status_akun di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('rt_id')->nullable()->after('id');
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif')->after('role');
        });

        // 2. Perluas enum role supaya include 'bendahara'
        // Laravel tidak bisa langsung ubah enum, pakai raw query
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','rt','penghuni','bendahara') NOT NULL");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rt_id', 'status_akun']);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','rt','penghuni') NOT NULL");
    }
};
