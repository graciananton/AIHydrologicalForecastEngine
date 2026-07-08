<?php
namespace App\Services;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Predictions;
use App\Models\StationMessages;

class StationMessageService
{

    public function normalizeParams(array $params): array{
        $params = [
            'stationId' => $params['stationId'] ?? "",
            'from' => isset($params['from']) ? Carbon::parse($params['from']) : Carbon::createFromTimestamp(0), // start of time 1970-01-00
            'to' => isset($params['to']) ? Carbon::parse($params['to']) : Carbon::now()->addDays(2),
            'order' => strtoupper($params['order'] ?? 'ASC') === 'DESC' ? 'DESC': 'ASC',
            'f' => $params['f'] ?? 'json',
            'limit' => $params['limit'] ?? 10,
        ];
        return $params;
    }
    public function filter(array $params):array{
        $query = StationMessages::query();

        if($params['stationId'] != null){
            $query->where('stationId',$params['stationId']);
        }

        $query->whereBetween('created_at', [
            $params['from'],
            $params['to']
        ]);

        $query->orderBy('created_at', $params['order']);

        $query->take($params['limit']);
        
        return $query->get()->toArray();
    }   
    public function generateStationMessage($stationId){
        $currentHour = Carbon::now()->startOfHour(); // 2026-07-08-18:00:00Z

        try{
            
            $url = "https://fast-api-54so.onrender.com/stationMessages?station_id=".$params['stationId'];
            $stationMessage = Http::connectTimeout(1200)->timeout(1200)->get($url);
            
            StationMessages::create(
                [
                'stationId' => $stationId,
                'currentTime' => $currentHour,
                'message' => $stationMessage
                ]
            );
        }
        catch(\Throwable $e){
            Log::error(
                "generateStationMessage failed",
                [
                    'stationId' => $stationId,
                    'error' => $e->getMessage()
                ]
            );

            throw $e;
        }
    }
}