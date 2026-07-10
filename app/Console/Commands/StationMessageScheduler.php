<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\StationMessageController;

class StationMessageScheduler extends Command
{
    protected $signature = 'stationMessage:scheduler';

    public function handle(StationMessageController $StationMessageController)
    {        
        $StationMessageController->sync();
    }
}