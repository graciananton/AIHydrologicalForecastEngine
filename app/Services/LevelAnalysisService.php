<?php
namespace App\Services;

use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LevelAnalysisService{
    public function normalizeParams(array $params): array{
        return [
            'stationId' => $params['stationId'] ?? '02KF001',
            'time' => Carbon::parse($params['time']) ?? Carbon::create(1970, 0, 0, 0, 0, 0),
            'level' => (string) $params['level'] ?? (string) 0.0,
            'mode' => $params['mode']
        ];
    }   

    public function process($params){
        try{  
            
            /* 
            $result contains:
            - percentile
            - message warning (e.g. warning, steady, etc)
            - AI message
            */
            Log::channel("laravel")->info("entering try catch statement");
            
            $url = "https://fast-api-54so.onrender.com/levelAnalysis?station_id="
                   .$params['stationId']."&time=".$params['time']."&level=".$params['level']."&mode=".$params['mode'];
            
            $response = Http::connectTimeout(1200)->timeout(1200)->get($url);

            Log::channel("laravel")->info("Response: ");
            Log::channel("laravel")->info($response);
            return $response;
        }
        catch(Throwable $e){
            Log::channel("laravel")->info("Catching error");
            return json_encode(["error" =>$e->getMessage()]);
        }
    }
}