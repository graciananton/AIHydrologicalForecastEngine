<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class StationMessageScheduler extends Command
{
    protected $signature = 'stationMessage:scheduler';

    public function handle()
    {        
        $response = Http::get(
            'http://gracian.ca/laravel/public/api/stationMessage',
        );
    }
}