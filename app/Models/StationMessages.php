<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StationMessages extends Model
{
    protected $table = 'station_messages';
    public $timestamps = true;
    protected $fillable = [
        'stationId',
        'message'
    ];
    protected $casts = [
        'stationId' => 'string',
        'message' => 'string'
    ];
}
