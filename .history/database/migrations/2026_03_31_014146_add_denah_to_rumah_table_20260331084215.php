<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('rumah', function (Blueprint $table) {
        $table->string('denah')->nullable(); // gambar denah
    });
}

public function down(): void
{
    Schema::table('rumah', function (Blueprint $table) {
        $table->dropColumn('denah');
    });
}
};
