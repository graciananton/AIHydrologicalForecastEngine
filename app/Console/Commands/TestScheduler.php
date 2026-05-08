<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TestScheduler extends Command
{
    protected $signature = 'test:scheduler';

    public function handle()
    {        
        Log::channel("laravel")->info("Test scheduler running ");
        $response = Http::get(
            'http://gracian.ca/laravel/public/api/testAll',
        );
    }
}