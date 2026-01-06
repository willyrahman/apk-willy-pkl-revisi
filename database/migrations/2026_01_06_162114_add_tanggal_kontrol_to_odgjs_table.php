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
        Schema::table('odgjs', function (Blueprint $table) {
            // Menambahkan kolom tanggal_kontrol setelah kolom keterangan
            // Kita buat nullable() agar data lama yang kosong tidak error
            $table->date('tanggal_kontrol')->nullable()->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('odgjs', function (Blueprint $table) {
            // Perintah untuk menghapus kolom jika migration di-rollback
            $table->dropColumn('tanggal_kontrol');
        });
    }
};
