<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class ModelService{
    public function train_model($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/train_model?station_id=%s',$stationId));
        $status = $response->json();
        return $status;
    }
    public function test_model($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/test_model?station_id=%s',$stationId));
        $rmse = $response->json();
        return $rmse;
    }
    public function plot_test($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/plot_test?station_id=%s',$stationId));
        file_put_contents(sprintf('images/test/%s',$stationId), $response->body());
        return true;
    }
    public function plot_train($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/plot_train?station_id=%s',$stationId));
        file_put_contents(sprintf('images/train/%s',$stationId), $response->body());
        return true;
    }
    public function future_set($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/future_set?station_id=%s',$stationId));
        $future_predictions = $response->json();
        return $future_predictions;
    }
    public function plot_future($stationId){
        $response = Http::timeout(120)->get(sprintf('https://fast-api-54so.onrender.com/plot_future?station_id=%s',$stationId));
        file_put_contents(sprintf('images/future/%s',$stationId), $response->body());
        return true;
    }
    public function stations(){
        $stations = Http::timeout(20)->get("http://gracian.ca/laravel/public/api/stations");
    }
}