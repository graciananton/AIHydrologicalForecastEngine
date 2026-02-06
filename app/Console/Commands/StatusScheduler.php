<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\StatusService;
use Illuminate\Support\Facades\Log;


class StatusScheduler extends Command
{
    protected $signature = 'status:scheduler';

    public function handle(StatusService $statusService):void
    {
        if($statusService->deleteRecords()){
            $statusService->updateStatus('deleted records beyond one month');
        }
    }
}