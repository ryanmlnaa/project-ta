use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel penghuni
            $table->foreignId('penghuni_id')
                  ->constrained('penghuni')
                  ->onDelete('cascade');

            // Kolom sesuai tampilan
            $table->dateTime('tanggal_pengaduan'); // tampil di tabel
            $table->string('kategori_masalah');    // kebersihan, keamanan, dll
            $table->text('deskripsi');             // deskripsi singkat

            // Status pengaduan
            $table->enum('status', ['diajukan', 'diproses', 'selesai'])
                  ->default('diajukan');

            // Tanggapan admin
            $table->text('tanggapan_admin')->nullable();
            $table->dateTime('tanggal_tanggapan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
