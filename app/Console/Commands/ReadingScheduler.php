<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReadingService;
use Illuminate\Support\Facades\Log;


class ReadingScheduler extends Command
{
    protected $signature = 'readingsProcessing:scheduler';

    public function handle(ReadingService $readingService)
    {        
        $response = Http::get(
            'http://gracian.ca/forecasting/public/api/readingsProcessing',
        );
    }
}