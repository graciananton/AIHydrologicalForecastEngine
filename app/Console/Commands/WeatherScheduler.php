<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Log;

class WeatherScheduler extends Command
{
    protected $signature = 'weather:scheduler';
    public function handle(WeatherService $weatherService)
    {
        $weatherService->sync();
    }
}