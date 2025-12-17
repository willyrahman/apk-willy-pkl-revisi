<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Hipertensi
    public function hipertensi()
    {
        return $this->belongsTo(Hipertensi::class, 'hipertensi_id');
    }
}
