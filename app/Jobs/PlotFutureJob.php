<?php
namespace App\Jobs;

use App\Services\ModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Imtigger\LaravelJobStatus\Trackable;
use App\Models\ApplicationErrors;

class PlotFutureJob implements ShouldQueue
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
            Log::channel("laravel")->info("Processing plotting future job");
            
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

            Log::channel("laravel")->info("Before plotFuture", [
                'stationId' => $this->stationId
            ]);
            
            $this->setInput(['stationId' => $this->stationId]);

            $ModelService->plotFuture($this->stationId);
            
            Log::channel("laravel")->info("Plotting future set");

            #Log::info("This is after plotting", [
            #    'statusId' => $this->getJobStatusId()
            #]);

            $this->update([
                'job_id' => $this->getJobStatusId()
            ]);

            Log::channel("laravel")->info("After plotFuture");

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

            $error = ApplicationErrors::create(
                [
                    'message' => "PlotFutureJob - finished for station ". $this->stationId,
                    'category' => 'App\Jobs\PlotFutureJob',
                    'status' => 'success'
                ]
            );

            Log::channel("laravel")->info($this->getJobStatusId());
        }
        catch(Exception $e){
            // this is where errors are mailed
            Log::channel("laravel")->info($e->getMessage());

            ApplicationErrors::create(
                [
                    'message' => $e->getMessage(),
                    'category' => 'App\Jobs\PlotFutureJob',
                    'status' => 'failed'
                ]
            );

            $this->update([
                'status' => 'failed'
            ]);

            $this->setOutput(['message' => 'Job not finished!']);

        }
    }
}