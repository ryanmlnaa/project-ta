<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();

            $table->string('password');

            $table->enum('role', ['admin', 'rt', 'user'])->default('user');

            $table->rememberToken();
            $table->timestamps();

            $table->string('photo', 255)->nullable();

            $table->string('otp_code', 10)->nullable();
            $table->dateTime('otp_expired')->nullable();

            $table->string('phone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
