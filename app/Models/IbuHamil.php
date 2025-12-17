<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbuHamil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ibu',
        'tanggal_lahir',
        'nik',
        'nama_suami',
        'alamat',
        'tgl_pemeriksaan_k6',
        'jaminan_kesehatan',
        'no_e_rekam_medis',
    ];
    public function balitas()
    {
        return $this->hasMany(Balita::class, 'ibu_hamil_id');
    }
}
