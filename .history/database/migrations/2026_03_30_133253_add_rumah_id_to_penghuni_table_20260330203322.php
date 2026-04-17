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
