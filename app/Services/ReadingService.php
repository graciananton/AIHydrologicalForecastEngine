<?php
namespace App\Services;
use App\Models\Reading;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReadingService
{
    public function sync(){
        $query = Station::query();
        $stations = $query->get()->toArray();
        $query = Reading::query();
        $stationCounter = 0;
        for($i=0;$i<count($stations);$i++){
            $stationId = $stations[$i]['stationId'];
            
            $url = "https://api.weather.gc.ca/collections/hydrometric-realtime/items?STATION_NUMBER={$stationId}&f=json&limit=10000&sortby=-DATETIME";
            $response = file_get_contents($url);
            $station = json_decode($response,true);

            $records = $station['features'];

            for($j=0;$j<count($records);$j++){

                //Log::channel("weather")->info($stationId." has ".$j);

                $record = $records[$j]['properties'];

                try{
                    // need to make this more efficient by just inserting, updating does nothing
                    $model = $query->updateOrCreate(
                        # checks duplicate unique values
                        [
                            'stationId'  => $record['STATION_NUMBER'],
                            'measuredAt' => $record['DATETIME'],
                        ],
                        # updates
                        [
                            'level' => $record['LEVEL'],
                        ]
                        # or inserts with 'stationId', 'measuredAt', 'level'
                    );
                    //if(!$model->wasRecentlyCreated){
                    //   break;
                    //}
                }
                catch(\Throwable $e){
                    $stationCounter = $stationCounter + 1;
                    Log::channel('weather')->info("$stationId ['Reading'] record not inserted $e");

                }
                
            }
            if($stationCounter > 0){
                Log::channel('weather')->info("There was an error at $stationId [Reading]".Carbon::now());
            }
            else{
                Log::channel('weather')->info("All records for $stationId [Reading] station inserted successfully at ".Carbon::now());
            }
        }
        if($stationCounter > 0){
            return false;
        }
        return true;
    }
    public function filter(array $params): array
    {
        $query = Reading::query();

        if ($params['stationId'] !== null) {
            $query->where('stationId', $params['stationId']);
        }

        $query->whereBetween('measuredAt', [
            $params['from'],
            $params['to']
        ]);

        $query->orderBy('measuredAt', $params['order']);

        if ($params['limit'] !== null) {
            $query->limit($params['limit']);
        }

        return $query->get()->toArray();
    }
    public function formatResults(array $results): array {
        foreach ($results as $i => $row) {
            foreach ($row as $key => $value) {

                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $results[$i][$key] = $decoded; 
                }
            }
        }
        return $results;
    }
    public function normalizeParams(array $params): array
    {
        return [
            'stationId' => $params['stationId'] ?? null,

            'from' => isset($params['from']) ? Carbon::parse($params['from']) : Carbon::createFromTimestamp(0), // start of time 1970-01-00

            'to' => isset($params['to']) ? Carbon::parse($params['to']) : Carbon::now(),

            'limit' => isset($params['limit']) ? (int) $params['limit'] : null,

            'order' => strtoupper($params['order'] ?? 'ASC') === 'DESC' ? 'DESC': 'ASC',

            'f' => $params['f'] ?? 'json'
        ];
    }
}
