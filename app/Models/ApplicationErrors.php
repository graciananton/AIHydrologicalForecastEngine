<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationErrors extends Model
{
    protected $table = 'application_errors';
    public $timestamps = true;
    // sets the fillable columns in the table
    protected $fillable = [
        'category',
        'status',
        'message'
    ];
    // sets the data type for each fillable column
    protected $casts = [
        'category' => 'string',
        'status' => 'string',
        'message' => 'string'
    ];

}
