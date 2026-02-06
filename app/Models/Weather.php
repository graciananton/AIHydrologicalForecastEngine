<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weather';
    public $timestamps = false;
    protected $fillable = [
        'stationId',
        'temperature',
        'rain',
        'wind',
        'measuredAt'
    ];
    protected $casts = [
        'stationId' => 'string',
        'temperature' => 'float',
        'rain' => 'float',
        'wind' => 'float',
        'measuredAt' => 'datetime'
    ];
}
