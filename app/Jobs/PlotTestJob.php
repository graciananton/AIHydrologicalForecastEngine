<?php
namespace App\Jobs;

use App\Services\ModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class PlotTestJob implements ShouldQueue
{
    # use dispatchable to run TrainModelJob::dispatch()
    use Dispatchable;
    protected $stationId;

    public function __construct($stationId)
    {
        $this->stationId = $stationId;
    }

    public function handle(ModelService $ModelService)
    {
        Log::channel("laravel")->info("Handling test plotting");
        
        $ModelService->plotTest($this->stationId);
    }
}