<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FutureScheduler extends Command
{
    protected $signature = 'future:scheduler';

    public function handle()
    {        
        Log::channel("laravel")->info("Test scheduler running ");
        $response = Http::get(
            'http://gracian.ca/laravel/public/api/futureSetAll',
        );
    }
}