<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'levels';
    public $timestamps = true;
    // sets the fillable columns in the table
    protected $fillable = [
        'stationId',
        'time',
        'level'
    ];
    // sets the data type for each fillable column
    protected $casts = [
        'stationId' => 'string',
        'time' => 'date',
        'level' => 'json'
    ];
}
