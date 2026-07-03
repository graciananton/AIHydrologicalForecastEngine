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
    public function filter(array $params):array{
        $query = Level::query();
        $query->where('stationId', $params['stationId']);
        return $query->get()->toArray();
    }

    public function sync($stationId){
        $query = Level::query();
        $rows = Http::get("https://api.weather.gc.ca/collections/hydrometric-daily-mean/items?STATION_NUMBER={$stationId}&f=json&limit=10000&filter=properties.LEVEL IS NOT NULL");

        for($i = 0;$i<count($data);$i++){
            $row = $data[$i];
            $result = User::firstOrCreate(['stationId' => $row['STATION_NUMBER'], 'level' => $row['LEVEL'], 'time' => $row['DATE']]);
            // result stores the user if the row already exists
            
        }

    }
}