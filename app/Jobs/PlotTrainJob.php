<?php
namespace App\Jobs;

use App\Services\ModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Imtigger\LaravelJobStatus\Trackable;

class PlotTrainJob implements ShouldQueue
{
    # use dispatchable to run TrainModelJob::dispatch()
    use Dispatchable, Trackable, Queueable;
    # by using Trackable, it injects all the public Trackable methods in this class
    protected $stationId;
    #public $queue = 'plotting';
    public function __construct($stationId)
    {
        $this->stationId = $stationId;
        $this->prepareStatus();
    }

    public function handle(ModelService $ModelService)
    {
        try{
            Log::channel("laravel")->info("Processing plotting test job");
            
            $this->update([
                'attempts'=> 1
            ]);

            $this->update([
                'status'=>'running'
            ]);

            $this->setProgressMax(100);
            $this->setProgressNow(0, 100);

            $this->update([
                'started_at' => now()
            ]);

            Log::channel("laravel")->info("Before plotTrain", [
                'stationId' => $this->stationId
            ]);


            if(!$ModelService->plotTrain($this->stationId)){
                // this is where the error handling begins
                $this->update([
                'status' => 'failed'
                ]);

                $this->setOutput(['message' => 'Job not finished!']);

                return;
            }
            
            Log::channel("laravel")->info("Plotting train set");

            #Log::info("This is after plotting", [
            #    'statusId' => $this->getJobStatusId()
            #]);

            $this->update([
                'job_id' => $this->getJobStatusId()
            ]);

            Log::channel("laravel")->info("After plotTrain");

            $this->setProgressNow(100, 100);
            $this->update([
                'status'=>'finished'
            ]);

            $this->update([
                'queue'=>'plotting'
            ]);

            $this->update([
                'finished_at' => now()
            ]);

            $this->setOutput(['message' => 'Job finished!']);
            
            $this->setInput(['stationId' => $this->stationId]);

            Log::channel("laravel")->info($this->getJobStatusId());
        }
        catch(Exception $e){
            Log::channel("laravel")->info($e->getMessage());
            $this->update([
                'status'=>'failed'
            ]);
        }
    }
}