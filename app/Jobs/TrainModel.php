<?php
namespace App\Jobs;

use App\Services\ModelService;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrainModelJob implements ShouldQueue
{
    protected $stationId;

    public function __construct($stationId)
    {
        $this->stationId = $stationId;
    }

    public function handle(ModelService $service)
    {
        $service->trainModel($this->stationId);
    }
}