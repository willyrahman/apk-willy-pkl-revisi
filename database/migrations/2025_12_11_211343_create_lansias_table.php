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
        Schema::create('lansias', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel hipertensis
            $table->foreignId('hipertensi_id')->nullable()->constrained('hipertensis')->onDelete('set null');

            $table->date('tanggal_kunjungan');
            $table->string('nik', 16);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('umur');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('kelurahan');

            // Data Kesehatan Fisik
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->float('imt')->nullable();
            $table->string('status_gizi')->nullable();
            $table->float('lingkar_perut');

            // Tekanan Darah & Lab
            $table->integer('sistole');
            $table->integer('diastole');
            $table->integer('gds')->nullable();
            $table->integer('kolesterol')->nullable();

            // Status Kesehatan Mental & Kemandirian
            $table->string('tingkat_kemandirian'); // AKS/ADL
            $table->string('gangguan_mental')->nullable();
            $table->string('status_emosional')->nullable();

            // --- TAMBAHAN KOLOM BARU ---
            $table->string('merokok')->nullable();                 // Ya / Tidak
            $table->string('depresi')->nullable();                 // Ya / Tidak
            $table->string('kurang_makan_sayur_buah')->nullable(); // Ya / Tidak
            $table->string('kurang_aktifitas_fisik')->nullable();  // Ya / Tidak
            // ---------------------------

            // Riwayat Penyakit
            $table->text('riwayat_penyakit_sendiri')->nullable();
            $table->text('riwayat_penyakit_keluarga')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lansias');
    }
};
