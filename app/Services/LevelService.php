<?php
namespace App\Services;

use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LevelService{

    public function normalizeParams(array $params): array{
        return [
            'stationId' => $params['stationId'] ?? '02KF001'
        ];
    }   

    public function sync($stationId){
        $query = Level::query();
        try{
            $rows = Http::get("https://api.weather.gc.ca/collections/hydrometric-daily-mean/items?STATION_NUMBER={$stationId}&f=json&limit=10000&filter=properties.LEVEL IS NOT NULL");
            $rows = json_decode($rows, true);
            $rows = $rows['features'];

            Log::channel("laravel")->info("Level-DATE");
            for($i = 0;$i<count($rows);$i++){
                $row = $rows[$i];
                Log::channel("laravel")->info($row['properties']['LEVEL']);
                Log::channel("laravel")->info($row['properties']['DATE']);
                $result = Level::firstOrCreate(
                    [
                        'stationId' => $row['properties']['STATION_NUMBER'], 
                        'level' => $row['properties']['LEVEL'], 
                        'time' => $row['properties']['DATE']
                    ]
                );                
            }
            
            return true;
        }

        catch(Throwable $e){
            report($e);
            return false;
        }
    }
}