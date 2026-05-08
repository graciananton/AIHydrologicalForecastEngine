<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Predictions extends Model
{
    protected $table = 'predictions';
    public $timestamps = true;
    // sets the fillable columns in the table
    protected $fillable = [
        'stationId',
        'prediction',
        'predictedFor'
    ];
    // sets the data type for each fillable column
    protected $casts = [
        'stationId' => 'string',
        'prediction' => 'double',
        'predictedFor' => 'datetime'
    ];
}
