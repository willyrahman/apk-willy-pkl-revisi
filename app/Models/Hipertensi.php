<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hipertensi extends Model
{
    //
    use HasFactory;

    protected $table = 'hipertensis';

    protected $fillable = [
        'tanggal',
        'nama_pasien',
        'nik',
        'no_asuransi',
        'jenis_kelamin',
        'no_telp',
        'skala_nyeri',
        'alamat',
        'rt',
        'rw',
        'jenis_kasus_1',
        'icd_x_1',
        'diagnosa_1',
        'no_e_rekam_medis',
    ];
}
