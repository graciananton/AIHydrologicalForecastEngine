<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\TestEvaluations;
use App\Models\Predictions;

class ModelService{
    public function trainModel($stationId){
        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/train_model?station_id=%s',$stationId));
        $status = $response->json();
        return $status;
    }

    public function testModel($stationId){
        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/test_model?station_id=%s',$stationId));
        $rmse = $response->json();
        Log::channel("laravel")->info(sprintf($rmse['RMSE']));

        TestEvaluations::create([
            'stationId' => $stationId,
            'error' => $rmse['RMSE']
        ]);
        return $rmse;
    }




    public function futureSet($stationId){
        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/future_set?station_id=%s',$stationId));
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





    public function plotFuture($stationId){
        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/plot_future?station_id=%s',$stationId));
        $dir = base_path("images/future");
        $filePath = $dir . '/'. $stationId . '.png';
        file_put_contents(
            $filePath,
            $response->body()
        );
        return true;
    }



    public function plotTrain($stationId){
        Log::channel("laravel")->info("Plotting train function");
        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/plot_train?station_id=%s',$stationId));
        
        # this checks if the query to the API endpoint was successful
        if (!$response->successful()) {
            Log::error('FastAPI request failed', [
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
        
        # this checks if image is valid, not corrupted, not obviously truncated
        # if any of these steps does not work, then it reutrns false
        $imageInfo = @imagecreatefrompng($filePath);

        if($imageInfo == false){
            return false;
        }
 
        return true;
    }


    
    public function plotTest($stationId){
        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/plot_test?station_id=%s',$stationId));
        $dir = base_path('images/test');
        $filePath = $dir . '/' . $stationId . '.png';
        file_put_contents(
            $filePath,
            $response->body()
        );        
        return true;
    }

    public function plot_test($stationId){
        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/plot_test?station_id=%s',$stationId));
        file_put_contents(sprintf('images/test/%s.png',$stationId), $response->body());
        return true;
    }
    public function plot_future($stationId){
        $response = Http::timeout(300)->get(sprintf('https://fast-api-54so.onrender.com/plot_future?station_id=%s',$stationId));
        file_put_contents(sprintf('images/future/%s.png',$stationId), $response->body());
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