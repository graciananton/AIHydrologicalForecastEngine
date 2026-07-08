<?php
namespace App\Services;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Predictions;

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
}