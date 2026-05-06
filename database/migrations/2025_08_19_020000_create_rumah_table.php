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
    Schema::create('rumah', function (Blueprint $table) {
    $table->id();
    $table->string('blok');
    $table->string('no_rumah');
    $table->enum('status', ['Kosong', 'Terisi'])->default('Kosong');
    $table->integer('luas_tanah')->nullable();
    $table->bigInteger('harga')->nullable();
    $table->string('gambar')->nullable();
    $table->text('keterangan')->nullable();
    $table->string('foto')->nullable();
    $table->unsignedBigInteger('rt_id')->nullable();

    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah');
    }
};
