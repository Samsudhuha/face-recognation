<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota_kab extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'provinsi_id', 'kode_kota_kab'
    ];
}
