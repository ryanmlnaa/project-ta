Schema::create('layanan', function (Blueprint $table) {
    $table->id();

    $table->foreignId('penghuni_id')
          ->constrained('penghuni')
          ->onDelete('cascade');

    $table->dateTime('tanggal_pengaduan');
    $table->string('kategori_masalah');
    $table->text('deskripsi');

    $table->enum('status', ['diajukan', 'diproses', 'selesai'])
          ->default('diajukan');

    $table->text('tanggapan_admin')->nullable();

    $table->timestamps();
});
