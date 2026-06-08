<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\TestEvaluations;
use App\Models\Predictions;

class ModelService{
    // trainModel - JOB
    public function trainModel($stationId){
        $response = Http::timeout(1200)->get(sprintf('https://fast-api-54so.onrender.com/train_model?station_id=%s',$stationId));
        
        if ($response->successful()) { // this is for 200-299 (success)
            $status = $response->json();
        }    

        if ($response->failed()) { // this is for 400-599 (server failed, the requesth has a problem)
            Log::error('Request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
        Log::channel("laravel")->info("Successfully trained model for ". $stationId);
        return $status;
    }

    public function testModel($stationId){
        $response = Http::timeout(1200)->get(sprintf('https://fast-api-54so.onrender.com/test_model?station_id=%s',$stationId));
        $rmse = $response->json();
        Log::channel("laravel")->info(sprintf($rmse['RMSE']));

        TestEvaluations::create([
            'stationId' => $stationId,
            'error' => $rmse['RMSE']
        ]);
        return $rmse;
    }




    public function futureSet($stationId){
        $response = Http::timeout(1200)->get(sprintf('https://fast-api-54so.onrender.com/future_set?station_id=%s',$stationId));
        $future_predictions = $response->json();
        foreach($future_predictions as $future_prediction) {
            Predictions::create([
                'stationId' => $future_prediction['stationId'],
                'prediction' => $future_prediction['levelAtHour'],
                'predictedFor' => $future_prediction['measuredAt']
            ]);

            Predictions::updateOrCreate(
                [
                    'stationId'   => $future_prediction['stationId'],
                    'predictedFor' => $future_prediction['measuredAt']
                ],
                [
                    'prediction' => $future_prediction['levelAtHour']
                ]
            );
        }
        return $future_predictions;
    }




    // plotFuture - JOB
    public function plotFuture($stationId){
        Log::channel("laravel")->info("plotFuture for ". $stationId);

        $response = Http::timeout(1200)->get(sprintf('https://fast-api-54so.onrender.com/plot_future?station_id=%s',$stationId));
        
        # this checks if the query to the API endpoint was successful
        if (!$response->successful()) {
            Log::error('plotFuture FastAPI request failed for '. $stationId, [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        }

        $dir = base_path("images/future");
        $filePath = $dir . '/'. $stationId . '.png';
        file_put_contents(
            $filePath,
            $response->body()
        );

        # this checks if image is not valid, not corrupted, or not obviously truncated
        # if any of these steps does not work, then it reutrns false
        $imageInfo = @imagecreatefrompng($filePath);

        if($imageInfo == false){
            Log::error('plotFuture image is not valid, corrupted, or obviously truncated');
            return false;
        }
        Log::channel("laravel")->info("plotFuture successfully for ". $stationId);

        return true;

    }


    // plotTrain - JOB
    public function plotTrain($stationId){
        Log::channel("laravel")->info("plotTrain for ". $stationId);
        $response = Http::timeout(1200)->get(sprintf('https://fast-api-54so.onrender.com/plot_train?station_id=%s',$stationId));
        
        # this checks if the query to the API endpoint was successful
        if (!$response->successful()) {
            Log::error('plotTrain FastAPI request failed for '. $stationId, [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        }

        $dir = base_path('images/train');
        $filePath = $dir . '/' . $stationId . '.png';

        file_put_contents(
            $filePath,
            $response->body()
        );  
        
        # this checks if image is not valid, not corrupted, or not obviously truncated
        # if any of these steps does not work, then it reutrns false
        $imageInfo = @imagecreatefrompng($filePath);

        if($imageInfo == false){
            Log::error('plotTrain image is not valid, corrupted, or obviously truncated');
            return false;
        }
        Log::channel("laravel")->info("plotTrain successfully for ". $stationId);

        return true;
    }
    
    // plotTest - JOB
    public function plotTest($stationId){
        Log::channel("laravel")->info("plotTest for ". $stationId);

        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/plot_test?station_id=%s',$stationId));

        # this checks if the query to the API endpoint was successful
        if (!$response->successful()) {
            Log::error('plotTest FastAPI request failed for '. $stationId, [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        }

        $dir = base_path('images/test');
        $filePath = $dir . '/' . $stationId . '.png';
        file_put_contents(
            $filePath,
            $response->body()
        );        
        
        # this checks if image is not valid, not corrupted, or not obviously truncated
        # if any of these steps does not work, then it reutrns false
        $imageInfo = @imagecreatefrompng($filePath);

        if($imageInfo == false){
            Log::error('plotTest image is not valid, corrupted, or obviously truncated for' . $stationId);
            return false;
        }
        Log::channel("laravel")->info("plotTest successfully for ". $stationId);

        return true;

    }

    public function getStationIds(){
        $stations = Http::timeout(300)->get("http://gracian.ca/laravel/public/api/stations");
        $stations = json_decode($stations,true);
        $stationIds = [];
        for($i=0;$i<count($stations);$i++){
            $stationId = $stations[$i]['stationId'];
            $stationIds[] = $stationId;
        }
        return $stationIds;
    }

}