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
        Schema::create('hipertensis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_pasien');
            $table->string('nik', 16);
            $table->string('no_asuransi')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_telp')->nullable();

            // --- PERUBAHAN DI SINI ---
            // Mengubah dari integer ke string agar bisa input teks (misal: "Nyeri Sedang", "5-6", dll)
            $table->string('skala_nyeri')->nullable();
            // -------------------------

            $table->text('alamat');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->enum('jenis_kasus_1', ['Baru', 'Lama']);
            $table->string('icd_x_1')->nullable();
            $table->string('diagnosa_1')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hipertensis');
    }
};
