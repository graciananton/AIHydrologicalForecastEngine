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
            $url = "https://api.weather.gc.ca/collections/hydrometric-realtime/items?STATION_NUMBER={$stationId}&f=json";
            $response = file_get_contents($url);
            $station = json_decode($response,true);

            Log::channel('weather')->info('inside station in ReadingService '.$stationId);

            $records = $station['features'];
            
            for($j=0;$j<count($records);$j++){
                $record = $records[$j]['properties'];

                try{
                    // need to make this more efficient by just inserting, updating does nothing
                    $query->updateOrCreate(
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
                }
                catch(\Throwable $e){
                    $stationCounter = $stationCounter + 1;
                    Log::channel('weather')->info("$stationId ['Reading'] record not inserted $e");

                }
            }
            if($stationCounter > 0){
                Log::channel('weather')->info("There was an error at $stationId [Reading]".Carbon::now());
                return false;
            }
            else{
                Log::channel('weather')->info("All records for $stationId [Reading] station inserted successfully at ".Carbon::now());
                return true;
            }
        }
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
