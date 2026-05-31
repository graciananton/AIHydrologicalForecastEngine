<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\JobStatuses;

class TrainService
{
    public function filter(array $params): array
    {
        $query = JobStatuses::query();


        if ($params['stationId'] !== null) {
            $query->where('input->stationId', $params['stationId']);
        }

        $query->whereBetween('updated_at', [
            $params['from'],
            $params['to']
        ]);

        $query->orderBy('updated_at', $params['order']);

        if ($params['limit'] !== null) {
            $query->limit($params['limit']);
        }

        $query->where('type','App\Jobs\TrainModelJob');

        Log::channel("laravel")->info("Before writing query");
        Log::channel("laravel")->info("Query");
        Log::channel("laravel")->info($query->toSql());
        
        
        return $query->get()->toArray();

    }
    public function normalizeParams(array $params): array
    {
        Log::channel("laravel")->info("Writing stationId");
        return [
            'stationId' => $params['stationId'] ?? null,

            'from' => isset($params['from']) ? Carbon::parse($params['from']) : Carbon::createFromTimestamp(0), // start of time 1970-01-00

            'to' => isset($params['to']) ? Carbon::parse($params['to']) : Carbon::now()->addDays(100),

            'limit' => isset($params['limit']) ? (int) $params['limit'] : 10,

            'order' => strtoupper($params['order'] ?? 'ASC') === 'DESC' ? 'DESC': 'ASC',

            'f' => $params['f'] ?? 'json'
        ];
    }
}
