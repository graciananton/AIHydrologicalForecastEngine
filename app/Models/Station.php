<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'stations';
    public $timestamps = false;
    protected $fillable = [
        'stationId',
        'name',
        'province',
        'latitude',
        'longitude'
    ];
    protected $casts = [
        'stationId' => 'string',
        'name' => 'string',
        'province' => 'string',
        'latitude' => 'string',
        'longitude' => 'string'
    ];
}
