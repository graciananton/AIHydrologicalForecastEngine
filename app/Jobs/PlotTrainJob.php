<?php
namespace App\Jobs;

use App\Services\ModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PlotTrainJob implements ShouldQueue
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
        $ModelService->plotTrain($this->stationId);
    }
}