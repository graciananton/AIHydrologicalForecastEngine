<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Log;

class WeatherScheduler extends Command
{
    protected $signature = 'weatherProcessing:scheduler';
    public function handle(WeatherService $weatherService)
    {
        $response = Http::get(
            'http://gracian.ca/forecasting/public/api/weatherProcessing',
        );
    }
}