<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobStatuses extends Model
{
    protected $table = 'job_statuses';

    protected $fillable = [
        'job_id',
        'type',
        'queue',
        'attempts',
        'progress_now',
        'progress_max',
        'status',
        'input',
        'output',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'job_id' => 'string',
        'type' => 'string',
        'queue' => 'string',

        'attempts' => 'integer',
        'progress_now' => 'integer',
        'progress_max' => 'integer',

        'status' => 'string',
        'input' => 'array',
        'output' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}