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
    Schema::table('penghuni', function (Blueprint $table) {
        $table->foreignId('rumah_id')
              ->after('alamat')
              ->constrained('rumah')
              ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('penghuni', function (Blueprint $table) {
        $table->dropForeign(['rumah_id']);
        $table->dropColumn('rumah_id');
    });
}
};
