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
        Schema::create('balitas', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel ibu_hamils
            $table->foreignId('ibu_hamil_id')->constrained('ibu_hamils')->onDelete('cascade');

            $table->string('nama_pasien'); // Nama Balita
            $table->string('nik', 16);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('umur'); // String agar bisa input "2 Tahun 3 Bulan"
            $table->text('alamat');
            $table->date('tgl_pemeriksaan');
            $table->string('poli_ruangan');
            $table->string('dokter_tenaga_medis');
            $table->text('keluhan_utama');
            $table->string('diagnosa_1')->nullable();
            $table->string('icd_x_1')->nullable();
            $table->text('obat')->nullable();
            $table->float('berat_badan'); // Float untuk koma (misal 10.5 kg)
            $table->float('tinggi_badan');
            $table->string('hasil_imt_status_gizi');
            $table->float('suhu');
            $table->string('apoteker')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balitas');
    }
};
