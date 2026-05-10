<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TestEvaluations;

class TestEvaluationsService
{
    public function filter(array $params): array
    {
        $query = TestEvaluations::query();

        if ($params['stationId'] !== null) {
            $query->where('stationId', $params['stationId']);
        }

        $query->whereBetween('updated_at', [
            $params['from'],
            $params['to']
        ]);

        $query->whereBetween('error', [
            $params['minError'],
            $params['maxError']
        ]);

        $query->orderBy('updated_at', $params['order']);

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

            'minError' => $params['minError'] ?? 0.0,

            'maxError' => $params['maxError'] ?? 100.0,
            
            'from' => isset($params['from']) ? Carbon::parse($params['from']) : Carbon::createFromTimestamp(0), // start of time 1970-01-00

            'to' => isset($params['to']) ? Carbon::parse($params['to']) : Carbon::now(),

            'limit' => isset($params['limit']) ? (int) $params['limit'] : null,

            'order' => strtoupper($params['order'] ?? 'ASC') === 'DESC' ? 'DESC': 'ASC',

            'f' => $params['f'] ?? 'json'
        ];
    }
}
