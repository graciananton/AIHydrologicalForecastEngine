<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WeatherScheduler extends Command
{
    protected $signature = 'weatherProcessing:scheduler';
    public function handle(WeatherService $weatherService)
    {
        $response = Http::get(
            'https://gracian.ca/forecasting/public/api/weatherProcessing',
        );
    }
}