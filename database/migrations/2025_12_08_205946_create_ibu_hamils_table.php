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
        Schema::create('ibu_hamils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ibu');
            $table->date('tanggal_lahir');
            $table->string('nik')->unique(); // NIK harus unik
            $table->string('nama_suami');
            $table->text('alamat');
            $table->date('tgl_pemeriksaan_k6')->nullable(); // Boleh kosong
            $table->enum('jaminan_kesehatan', ['BPJS Mandiri', 'BPJS PBI', 'Asuransi Swasta', 'Umum']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibu_hamils');
    }
};
