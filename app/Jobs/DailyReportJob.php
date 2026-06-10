<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FutureScheduler extends Command
{
    protected $signature = 'dailyReport:scheduler';

    public function handle()
    {        
        $response = Http::get(
            'http://gracian.ca/laravel/public/api/dailyReport',
        );
    }
}