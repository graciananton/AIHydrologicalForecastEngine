<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AwakeScheduler extends Command
{
    protected $signature = 'awake:scheduler';

    public function handle()
    {        
        Log::channel("weather")->info("Awake scheduler");
        $response = Http::get(
            'https://fast-api-54so.onrender.com/',
        );
    }
}

#* * * * * cd /kunden/homepages/3/d1017242952/htdocs/forecasting && /usr/bin/php8.3-cli artisan queue:work --stop-when-empty