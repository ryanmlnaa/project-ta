<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite tidak support ALTER COLUMN untuk enum,
        // jadi kita pakai pendekatan ubah nilai langsung via DB statement
        // dan tambah kolom baru yang dibutuhkan

        Schema::table('users', function (Blueprint $table) {
            // Penghubung bendahara → RT yang membuatnya
            // Nullable karena admin & RT tidak punya rt_id
            $table->unsignedBigInteger('rt_id')
                  ->nullable()
                  ->after('role');

            // Status akun: aktif atau nonaktif
            // Dipakai untuk mekanisme ganti bendahara (nonaktifkan lama, buat baru)
            $table->enum('status_akun', ['aktif', 'nonaktif'])
                  ->default('aktif')
                  ->after('rt_id');

            $table->foreign('rt_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });

        // SQLite menyimpan enum sebagai TEXT dengan CHECK constraint.
        // Karena migration awal pakai enum(['admin','user']),
        // kita perlu recreate tabel agar bisa tambah nilai 'rt' dan 'bendahara'.
        // TAPI karena data production mungkin sudah ada, gunakan cara aman:
        // drop constraint lama dan buat ulang via raw SQL (SQLite-safe).

        // Untuk SQLite: ubah kolom role menjadi TEXT dulu (hapus CHECK lama)
        // Cara paling aman di SQLite adalah lewat migrasi manual tabel sementara.

        // Cek apakah pakai SQLite
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            // SQLite: tidak bisa ALTER COLUMN, jadi kita rebuild tabel users
            // Salin data, drop, recreate dengan enum baru, salin balik

            DB::statement('PRAGMA foreign_keys = OFF');

            DB::statement('
                CREATE TABLE users_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    username TEXT NOT NULL UNIQUE,
                    email TEXT NOT NULL UNIQUE,
                    password TEXT NOT NULL,
                    role TEXT NOT NULL DEFAULT "user"
                        CHECK(role IN ("admin","user","rt","bendahara")),
                    rt_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
                    status_akun TEXT NOT NULL DEFAULT "aktif"
                        CHECK(status_akun IN ("aktif","nonaktif")),
                    photo TEXT,
                    otp_code TEXT,
                    otp_expired DATETIME,
                    remember_token TEXT,
                    created_at DATETIME,
                    updated_at DATETIME
                )
            ');

            DB::statement('
                INSERT INTO users_new
                    (id, name, username, email, password, role,
                     rt_id, status_akun, photo, otp_code, otp_expired,
                     remember_token, created_at, updated_at)
                SELECT
                    id, name, username, email, password, role,
                    NULL, "aktif", photo, otp_code, otp_expired,
                    remember_token, created_at, updated_at
                FROM users
            ');

            DB::statement('DROP TABLE users');
            DB::statement('ALTER TABLE users_new RENAME TO users');

            DB::statement('PRAGMA foreign_keys = ON');

        } else {
            // MySQL / PostgreSQL: langsung ALTER COLUMN
            DB::statement("
                ALTER TABLE users
                MODIFY COLUMN role
                ENUM('admin','user','rt','bendahara') NOT NULL DEFAULT 'user'
            ");
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['rt_id']);
            $table->dropColumn(['rt_id', 'status_akun']);
        });

        // Kembalikan enum role ke semula (hanya admin & user)
        $driver = DB::getDriverName();
        if ($driver !== 'sqlite') {
            DB::statement("
                ALTER TABLE users
                MODIFY COLUMN role
                ENUM('admin','user') NOT NULL DEFAULT 'user'
            ");
        }
    }
};
