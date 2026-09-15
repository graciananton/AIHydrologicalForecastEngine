<?php
namespace App\Jobs;

use App\Services\StationMessageDailyReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Imtigger\LaravelJobStatus\Trackable;
use App\Models\ApplicationErrors;

class StationMessageDailyReportJob implements ShouldQueue
{
    # use dispatchable to run TrainModelJob::dispatch()
    use Dispatchable, Trackable, Queueable;
    # by using Trackable, it injects all the public Trackable methods in this class
    protected $user;
    #public $queue = 'plotting';
    public function __construct($user)
    {
        $this->user = $user;
        $this->prepareStatus();
    }

    public function handle(StationMessageDailyReportService $StationMessageDailyReportService)
    {
        try{
            Log::channel("laravel")->info("Processing training model");

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

            $this->setInput(['stationId' => $this->user->name]);

            $StationMessageDailyReportService->sendStationMessageDailyReport($user);

            $this->update([
                'job_id' => $this->getJobStatusId()
            ]);

            $this->setProgressNow(100, 100);

            $this->update([
                'status'=>'finished'
            ]);

            $this->update([
                'queue'=>'training'
            ]);

            $this->update([
                'finished_at' => now()
            ]);

            $this->setOutput(['message' => 'Job finished!']);

            $error = ApplicationErrors::create(
                [
                    'message' => "StationMessageDailyReportJob - finished for user ". $this->user->name,
                    'category' => 'App\Jobs\StationMessageJob',
                    'status' => 'success'
                ]
            );

            Log::channel("laravel")->info($this->getJobStatusId());
        }
        catch(\Throwable $e){
            // this is for each station

            Log::channel("laravel")->info($e->getMessage());
            
            ApplicationErrors::create(
                [
                    'message' => $e->getMessage(),
                    'category' => 'App\Jobs\StationMessageService',
                    'status' => 'failed'
                ]
            );

            $this->update([
                'status' => 'failed'
            ]);
            
            $this->setOutput(['message' => 'Job not finished - '. $e->getMessage()]);
        }
    }
    
}