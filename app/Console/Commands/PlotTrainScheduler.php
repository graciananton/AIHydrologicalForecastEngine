<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReadingService;
use Illuminate\Support\Facades\Log;


class PlotTrainScheduler extends Command
{
    protected $signature = 'plotTrain:scheduler';

    public function handle(ReadingService $readingService)
    {        
        $readingService->sync();
    }
}