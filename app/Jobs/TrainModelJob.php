<?php
namespace App\Jobs;

use App\Services\ModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\Dispatchable;

class TrainModelJob implements ShouldQueue
{
    use Dispatchable;
    protected $stationId;

    public function __construct($stationId)
    {
        $this->stationId = $stationId;
    }

    public function handle(ModelService $ModelService)
    {
        $ModelService->trainModel($this->stationId);
    }
}