<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odgj extends Model
{
    use HasFactory;

    protected $table = 'odgjs'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'rt',
        'status_pasien',
        'jadwal_kontrol',
        'diagnosis',
        'keterangan',
        'no_e_rekam_medis',
    ];
}
