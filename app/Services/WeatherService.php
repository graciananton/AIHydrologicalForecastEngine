<?php
namespace App\Services;
use App\Models\Weather;
use App\Models\Station;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WeatherService {
    public function sync(){
        $interval = 24;
        $query = Station::query();
        $stations = $query->get()->toArray();

        $formatted = Carbon::now('America/Toronto')->startOfHour()->format('Y-m-d\TH:00');
        for($i=0;$i<count($stations);$i++){
            $station = $stations[$i];
            $stationId = $station['stationId'];
            $longitude = $station['longitude'];
            $latitude = $station['latitude'];

            $url = 
            "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&hourly=temperature_2m,precipitation,snowfall,relative_humidity_2m,pressure_msl,rain,wind_speed_10m&timezone=America/Toronto&f=json";
            $response = file_get_contents($url);
            $data = json_decode($response,true);
            
            $index = 0;
            for($j=0;$j<count($data['hourly']['time']);$j++){
                if($data['hourly']['time'][$j] == $formatted){
                    $index = $j;
                }
            }
            
            $hours = [];
            for($z=$index;$z<$index+$interval+1;$z++){
                $hours[] = $z;
            }
            $weatherFeatures = array_keys($data['hourly']);

            $stationCounter = 0;
            for($a=0;$a<count($hours);$a++){
                $hour = $hours[$a];
                $weatherData = [];

                $weatherData['stationId'] = $stationId;

                for($b=0;$b<count($weatherFeatures);$b++)
                {
                    $weatherFeature = $weatherFeatures[$b];
                    
                    $weatherData[$weatherFeature] = $data['hourly'][$weatherFeature][$hour];
                }

                $time = $weatherData['time'];

                $weatherData = json_encode($weatherData);

                try{
                    DB::table('weather')->upsert(
                        [
                            [
                                'stationId'  => $stationId,
                                'weather'    => $weatherData,
                                'measuredAt' => $time,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]
                        ],
                        ['stationId','measuredAt'],              // unique key
                        ['weather', 'updated_at']   // columns to update on duplicate
                    );
                }
                catch(\Throwable $e){
                    $stationCounter = $stationCounter + 1;
                    Log::channel('weather')->info("$stationId [Weather] record not inserted $e");
                }
            }
            if($stationCounter > 0){
                Log::channel('weather')->info("There was an error at $stationId [Weather]".Carbon::now());
                return false;
            }
            else{
                Log::channel('weather')->info("All records for $stationId [Weather] station inserted successfully at ".Carbon::now());
                return true;
            }
        }

    }
    public function filter(array $params):array{
        $query = Weather::query();
        if($params['stationId'] != null){
            $query->where('stationId',$params['stationId']);
        }
        if($params['temperatureAtLeast'] != null){
            $query->where('temperature', '>=',$params['temperatureAtLeast']);
        }
        if($params['temperatureAtMost'] != null){
            $query->where('temperature', '<=', $params['temperatureAtMost']);
        }
        if($params['windAtLeast'] != null){
            $query->where('wind','>=',$params['windAtLeast']);
        }
        if($params['windAtMost'] != null){
            $query->where('wind','<=',$params['windAtMost']);
        }
        if($params['rainAtLeast'] != null){
            $query->where('rain','>=',$params['rainAtLeast']);
        }
        if($params['rainAtMost'] != null){
            $query->where('rain','<=',$params['rainAtMost']);
        }

        return $query->get()->toArray();
    }
    public function normalizeParams(array $params):array{
        return [

            'stationId' => $params['stationId'] ?? null,

            'temperatureAtLeast' => $params['temperatureAtLeast'] ?? null,
            'windAtLeast' => $params['windAtLeast'] ?? null,
            'rainAtLeast' => $params['rainAtLeast'] ?? null,

            'temperatureAtMost' => $params['temperatureAtMost'] ?? null,
            'windAtMost' => $params['windAtMost'] ?? null,
            'rainAtMost' => $params['rainAtMost'] ?? null,
            'f' => $params['f'] ?? 'json'
        ];
    }
}