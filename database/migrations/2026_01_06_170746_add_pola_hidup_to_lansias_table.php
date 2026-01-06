<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lansias', function (Blueprint $table) {
            // Menambahkan kolom baru
            $table->string('merokok')->nullable(); // Isi: Ya / Tidak
            $table->string('kurang_makan_sayur_buah')->nullable(); // Isi: Ya / Tidak
            $table->string('kurang_aktifitas_fisik')->nullable(); // Isi: Ya / Tidak
        });
    }

    public function down()
    {
        Schema::table('lansias', function (Blueprint $table) {
            $table->dropColumn(['merokok', 'kurang_makan_sayur_buah', 'kurang_aktifitas_fisik']);
        });
    }
};
