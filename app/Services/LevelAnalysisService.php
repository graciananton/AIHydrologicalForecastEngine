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
            'time' => new Date($params['time']).toISOString() ?? new Date(0).toISOString(),
            'level' => (string) $params['level'] ?? (string) 0.0
        ];
    }   

    public function sync($params){
        try{  
            /* 
            $result contains:
            - percentile
            - message warning (e.g. warning, steady, etc)
            - AI message
            */
            $result = Http::get(
                "https://fast-api-54so.onrender.com/levelAnalysis?station_id="
                +$params['stationId']
                +"&time="+$params['time']
                +"&level="
                +$params['level']
            );

            return $result;
        }

        catch(Throwable $e){

        }
    }
}