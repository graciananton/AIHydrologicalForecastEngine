<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\TestEvaluations;
use App\Models\Predictions;

class ModelService{
    // trainModel - JOB
    public function trainModel($stationId){
        try{
            //$response = Http::connectTimeout(1200)->timeout(1200)->get($url);
            //$response = Http::timeout(1200)->get(sprintf('https://fast-api-54so.onrender.com/train_model?station_id=%s',$stationId));
            
            $url = sprintf('https://fast-api-54so.onrender.com/train_model?station_id=%s', $stationId);

            $response = Http::connectTimeout(1200)->timeout(1200)->get($url);

            if (!$response->successful()) { // this is for 200-299 (success)
                throw new \RuntimeException(
                    "trainModel FastAPI request failed for ".$stationId
                );
            }   
            $status = $response->json();

            if (!is_array($status)) {
                throw new \UnexpectedValueException(
                   'trainModel response is not valid output for '.$stationId
                );
            }

            Log::channel("laravel")->info("Successfully trained model for ". $stationId);
        }
        catch(\Throwable $e){
            Log::error(
                "trainModel failed",
                [
                    'stationId' => $stationId,
                    'error' => $e->getMessage()
                ]
            );
            throw $e;
        }
    }

    // plotTrain - JOB
    public function plotTrain($stationId){
        try{
            Log::channel("laravel")->info("plotTrain for ". $stationId);
            //$response = Http::timeout(1200)->get(sprintf('https://fast-api-54so.onrender.com/plot_train?station_id=%s',$stationId));
            $url = sprintf('https://fast-api-54so.onrender.com/plot_train?station_id=%s',$stationId);

            $response = Http::connectTimeout(1200)->timeout(1200)->get($url);

            Log::channel("laravel")->info("Response successful status: ". $response->successful());

            # this checks if the query to the API endpoint was successful
            if (!$response->successful()) { // this is for 200-299 (success)
                throw new \RuntimeException(
                    "plotTrain FastAPI request failed for ".$stationId
                );
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
                Log::channel('laravel')->info('plotTrain image is not valid, corrupted, or obviously truncated');

                throw new \UnexpectedValueException(
                    "plotTrain image is not valid, corrupted, or obviously truncated"
                );
            }
            Log::channel("laravel")->info("plotTrain successfully for ". $stationId);
        }
        catch(\Throwable $e){
            Log::error(
                "plotTrain failed",
                [
                    'stationId' => $stationId,
                    'error' => $e->getMessage()
                ]
            );
            throw $e;
        }
    }


    public function testModel($stationId){
        try{
            $url = sprintf('https://fast-api-54so.onrender.com/test_model?station_id=%s',$stationId);

            $response = Http::connectTimeout(1200)->timeout(1200)->get($url);

            if (!$response->successful()) { // this is for 200-299 (success)
                throw new \RuntimeException(
                    "testModel FastAPI request failed for ".$stationId
                );
            }   

            $rmse = $response->json();
            
            if (!is_array($rmse)) {
                throw new \UnexpectedValueException(
                   'testModel response is not valid output for '.$stationId
                );
            }

            TestEvaluations::create([
                'stationId' => $stationId,
                'error' => $rmse['RMSE']
            ]);

            return $rmse;
        }
        catch(\Throwable $e){
            Log::error(
                "testModel failed",
                [
                    'stationId' => $stationId,
                    'error' => $e->getMessage()
                ]
            );
            throw $e;
        }
    }


    // plotTest - JOB
    public function plotTest($stationId){
        try{
            Log::channel("laravel")->info("plotTest for ". $stationId);

            $url = sprintf('https://fast-api-54so.onrender.com/plot_test?station_id=%s',$stationId);
            $response = Http::connectTimeout(1200)->timeout(1200)->get($url);

            # this checks if the query to the API endpoint was successful
            if (!$response->successful()) { // this is for 200-299 (success)
                throw new \RuntimeException(
                    "plotTest FastAPI request failed for ".$stationId
                );
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
                Log::error('plotTest image is not valid, corrupted, or obviously truncated');

                throw new \UnexpectedValueException(
                    "plotTest image is not valid, corrupted, or obviously truncated"
                );
            }

            Log::channel("laravel")->info("plotTest successfully for ". $stationId);
        }
        catch(\Throwable $e){
            Log::error(
                "plotTest failed",
                [
                    'stationId' => $stationId,
                    'error' => $e->getMessage()
                ]
            );
            throw $e;
        }
    }

    public function futureSet($stationId){
        try{
            $url = sprintf('https://fast-api-54so.onrender.com/future_set?station_id=%s',$stationId);
            $response = Http::connectTimeout(1200)->timeout(1200)->get($url);            
            
            # this checks if the query to the API endpoint was successful
            if (!$response->successful()) { // this is for 200-299 (success)
                throw new \RuntimeException(
                    "futureSet FastAPI request failed for ".$stationId
                );
            }   


            $futurePredictions = $response->json();

            if (!is_array($futurePredictions)) {
                throw new \UnexpectedValueException(
                   'futureSet response is not valid output for '.$stationId
                );
            }

            foreach($futurePredictions as $futurePrediction) {
                $prediction = Predictions::updateOrCreate(
                    [
                        'stationId'   => $futurePrediction['stationId'],
                        'predictedFor' => $futurePrediction['measuredAt']
                    ],
                    [
                        'prediction' => $futurePrediction['levelAtHour']
                    ]
                );

                Log::channel('laravel')->info("Prediction exists ".$prediction->exists);
                Log::channel('laravel')->info("Predicted for ".$prediction->predictedFor);

                if(!$prediction instanceof Predictions || !$prediction->exists){
                    throw new \RuntimeException(
                        'Prediction record was not created successfully'
                    );
                }
                Log::channel("laravel")->info("Prediction created for ".$futurePrediction['stationId']);
            }
            return $futurePredictions;
        }
        catch(\Throwable $e){
            Log::error(
                "futureSet prediction failed",
                [
                    'stationId' => $stationId,
                    'error' => $e->getMessage()
                ]
            );
            throw $e;
        }
    }




    // plotFuture - JOB
    public function plotFuture($stationId){
        try{
            Log::channel("laravel")->info("plotFuture for ". $stationId);

            $url = sprintf('https://fast-api-54so.onrender.com/plot_future?station_id=%s',$stationId);
            
            $response = Http::connectTimeout(1200)->timeout(1200)->get($url);

            # this checks if the query to the API endpoint was successful
            if (!$response->successful()) { // this is for 200-299 (success)
                throw new \RuntimeException(
                    "plotFuture FastAPI request failed for ".$stationId
                );
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

                throw new \UnexpectedValueException(
                    "plotFuture image is not valid, corrupted, or obviously truncated"
                );
            }

            Log::channel("laravel")->info("plotFuture successfully for ". $stationId);
        }
        catch(\Throwable $e){
            Log::error(
                "plotFuture failed",
                [
                    'stationId' => $stationId,
                    'error' => $e->getMessage()
                ]
            );
            throw $e;
        }
    }
    
    public function getStationIds(){
        $stations = Http::timeout(1200)->get("http://gracian.ca/laravel/public/api/stations");

        $stations = json_decode($stations,true);
        $stationIds = [];
        for($i=0;$i<count($stations);$i++){
            $stationId = $stations[$i]['stationId'];
            $stationIds[] = $stationId;
        }
        return $stationIds;
    }

}