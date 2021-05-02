<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Racks extends Model
{
    use HasFactory;

    protected $fillable = [
        'distance_rank',
        'storage_coefficient_s',
        'loaded'
    ];
    
    protected $table = 'racks';
}
