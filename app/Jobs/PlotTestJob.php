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
            
            Log::channel("laravel")->info("Plotting test set");

            #Log::info("This is after plotting", [
            #    'statusId' => $this->getJobStatusId()
            #]);

            $this->update([
                'job_id' => $this->getJobStatusId()
            ]);

            Log::channel("laravel")->info("After plotTest");

            $this->setProgressNow(100, 100);
            $this->update([
                'status'=>'finished'
            ]);
            $this->update([
                'finished_at' => now()
            ]);

            $this->setOutput(['message' => 'Job finished!']);
            
            dd($this->getJobStatusId());
    }
}