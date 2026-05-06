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
        try {
            Log::channel("laravel")->info("Processing plotting test job");

            $this->update([
                'status'=>'running'
            ]);

            $this->setProgressMax(100);
            $this->setProgressNow(0, 100);

            $this->update([
                'started_at' => now()
            ]);

            Log::channel("laravel")->info("Before plotTest", [
                'stationId' => $this->stationId
            ]);

            $ModelService->plotTest($this->stationId);
            
            #Log::info("This is after plotting");

            #$this->update([
            #    'job_id' => $this->getJobStatusId()
            #]);

            Log::channel("laravel")->info("After plotTest");

            $this->setProgressNow(100, 100);
            $this->update([
                'status'=>'finished'
            ]);
            $this->update([
                'finished_at' => now()
            ]);

            $this->setOutput(['message' => 'Job finished!']);

        } 
        catch (\Throwable $e) {
            Log::channel("laravel")->error("PlotTestJob failed", [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            $this->update([
                'status' => "failed"
            ]);

            $this->setOutput([
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }
}