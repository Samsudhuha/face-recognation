<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tps extends Model
{
    use HasFactory;

    protected $fillable = [
        'provinsi_id', 'kota_kab_id', 'kecamatan_id', 'kelurahan_id', 'tps', 'jumlah'
    ];
}
