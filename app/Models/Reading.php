<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    protected $table = 'readings';
    public $timestamps = true;
    // sets the fillable columns in the table
    protected $fillable = [
        'stationId',
        'level',
        'measuredAt'
    ];
    // sets the data type for each column
    protected $casts = [
        'stationId' => 'string',
        'level' => 'string',
        'measuredAt' => 'datetime'
    ];
}
