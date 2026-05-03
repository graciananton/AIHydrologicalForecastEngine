<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ModelService{
    public function trainModel($stationId){

        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/train_model?station_id=%s',$stationId));
        $status = $response->json();
        return $status;
    }

    public function testModel($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/test_model?station_id=%s',$stationId));
        $rmse = $response->json();
        Log::channel("laravel")->info(sprintf("%s RMSE score %f",$stationId, $rmse));
        return $rmse;
    }
    public function futureSet($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/future_set?station_id=%s',$stationId));
        $future_predictions = $response->json();
        return $future_predictions;
    }

    public function plotTrain($stationId){
        Log::channel("Plot train");
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/plot_train?station_id=%s',$stationId));
        $dir = base_path('images/train');
        $filePath = $dir . '/' . $stationId . '.png';
        Log::channel("larvel")->info("Writing into file path");
        Log::channel("laravel")->info($filePath);
        file_put_contents(
            $filePath,
            $response->body()
        );        
        return true;
    }


    
    public function plot_test($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/plot_test?station_id=%s',$stationId));
        file_put_contents(sprintf('images/test/%s.png',$stationId), $response->body());
        return true;
    }
    public function plot_future($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/plot_future?station_id=%s',$stationId));
        file_put_contents(sprintf('images/future/%s.png',$stationId), $response->body());
        return true;
    }
    public function getStationIds(){
        $stations = Http::timeout(20)->get("http://gracian.ca/laravel/public/api/stations");
        $stations = json_decode($stations,true);
        $stationIds = [];
        for($i=0;$i<count($stations);$i++){
            $stationId = $stations[$i]['stationId'];
            $stationIds[] = $stationId;
        }
        return $stationIds;
    }
}