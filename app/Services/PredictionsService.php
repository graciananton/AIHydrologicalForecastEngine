<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\PredictionsService;
use App\Models\Predictions;

class PredictionsService
{
    public function filter(array $params): array
    {
        $query = Predictions::query();

        if ($params['stationId'] !== null) {
            $query->where('stationId', $params['stationId']);
        }

        $query->whereBetween('predictedFor', [
            $params['from'],
            $params['to']
        ]);
        
        $query->whereBetween('prediction', [
            $params['minPrediction'],
            $params['maxPrediction']
        ]);

        $query->orderBy('predictedFor', $params['order']);

        if ($params['limit'] !== null) {
            $query->limit($params['limit']);
        }
        Log::channel("laravel")->info("Query");
        Log::channel("laravel")->info($query->toSql());

        return $query->get()->toArray();
    }
    public function normalizeParams(array $params): array
    {
        return [
            'stationId' => $params['stationId'] ?? null,

            'minPrediction' => $params['minPrediction'] ?? -100.0,

            'maxPrediction' => $params['maxPrediction'] ?? 100.0,
            
            'from' => isset($params['from']) ? Carbon::parse($params['from']) : Carbon::createFromTimestamp(0), // start of time 1970-01-00

            'to' => isset($params['to']) ? Carbon::parse($params['to']) : Carbon::now()->addDays(100),

            'limit' => isset($params['limit']) ? (int) $params['limit'] : null,

            'order' => strtoupper($params['order'] ?? 'ASC') === 'DESC' ? 'DESC': 'ASC',

            'f' => $params['f'] ?? 'json'
        ];
    }
}
