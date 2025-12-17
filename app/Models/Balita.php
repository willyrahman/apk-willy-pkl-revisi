<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    //
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Setiap Balita milik satu Ibu
    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibu_hamil_id');
    }
}
