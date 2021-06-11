<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_penduduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nik', 'kk', 'antrean', 'tps_id', 'status'
    ];
}
