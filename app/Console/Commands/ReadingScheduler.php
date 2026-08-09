<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ReadingScheduler extends Command
{
    protected $signature = 'readingsProcessing:scheduler';

    public function handle()
    {        
        $response = Http::get(
            'https://gracian.ca/forecasting/public/api/readingsProcessing',
        );
    }
}