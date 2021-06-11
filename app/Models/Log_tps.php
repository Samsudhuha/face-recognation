<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_tps extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'info', 'description'
    ];
}