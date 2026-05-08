<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestEvaluations extends Model
{
    protected $table = "test_evaluations";
    public $timestamps = true;
    // sets the fillable columns in the table
    protected $fillable = [
        'stationId',
        'error',
    ];
    // sets the data type for each fillable column
    protected $casts = [
        'stationId' => 'string',
        'error' => 'double',
    ];

}
