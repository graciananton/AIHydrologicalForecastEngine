<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class StationMessageDailyReport extends Command
{
    protected $signature = 'stationMessageDailyReport:scheduler';
                            
    public function handle()
    {        
        Log::channel("weather")->info("handling station message dialy report");
        $response = Http::timeout(1200)->get(
            'https://gracian.ca/laravel/public/api/stationMessageDailyReport',
        );
    }
}