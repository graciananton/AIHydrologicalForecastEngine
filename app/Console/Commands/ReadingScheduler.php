<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReadingService;
use Illuminate\Support\Facades\Log;


class ReadingScheduler extends Command
{
    protected $signature = 'reading:scheduler';

    public function handle(ReadingService $readingService)
    {
        Log::channel("weather")->info("handle() ReadingScheduler function");
        $readingService->sync();
    }
}