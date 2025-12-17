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
        Schema::table('hipertensis', function (Blueprint $table) {
            $table->string('no_e_rekam_medis')->nullable()->after('id'); // Tambahkan setelah ID
        });
    }

    public function down()
    {
        Schema::table('hipertensis', function (Blueprint $table) {
            $table->dropColumn('no_e_rekam_medis');
        });
    }
};
