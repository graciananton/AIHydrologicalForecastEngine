<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerifications extends Model
{
    protected $table = 'email_verifications';
    public $timestamps = true;
    // sets the fillable columns in the table
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'attempts',
        'attempts_start_at',
        'last_sent_at'
    ];
    // sets the data type for each fillable column
    protected $casts = [
        'email' => 'string',
        'otp' => 'string',
        'expires_at' => 'timestamp',
        'attempts' => 'int',
        'attempts_start_at' => 'timestamp',
        'last_sent_at' => 'timestamp'
    ];

}
