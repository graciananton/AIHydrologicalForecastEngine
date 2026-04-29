<?php
namespace App\Services;

class ModelService{
    public function getStations(){
        Http::post('http://127.0.0.1:8000/hello');
    }
}