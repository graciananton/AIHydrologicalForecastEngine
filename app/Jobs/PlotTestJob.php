<?php
namespace App\Jobs;

use App\Services\ModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Imtigger\LaravelJobStatus\Trackable;

class PlotTestJob implements ShouldQueue
{
    # use dispatchable to run TrainModelJob::dispatch()
    use Dispatchable, Trackable;
    # by using Trackable, it injects all the public Trackable methods in this class
    protected $stationId;

    public function __construct($stationId)
    {
        $this->stationId = $stationId;
        $this->prepareStatus();
    }

    public function handle(ModelService $ModelService)
    {
        Log::channel("laravel")->info("Processing plotting test job");
        $this->setProgressNow(10, 100); // Set current progress
        $this->setProgressMax(100); // Set max progress
        $ModelService->plotTest($this->stationId);
        $this->setOutput(['message' => 'Job finished!']);
    }
}