<?php
namespace App\Services;

use App\Models\Status;
use App\Models\Reading;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LevelService{
    
    public function normalizeParams(array $params): array{
        return [
            'from' => isset($params['from']) ? Carbon::parse($params['from']) : Carbon::createFromTimestamp(0), // start of time 1970-01-00

            'to' => isset($params['to']) ? Carbon::parse($params['to']) : Carbon::now(),

            'limit' => isset($params['limit']) ? (int) $params['limit'] : null,

            'order' => strtoupper($params['order'] ?? 'ASC') === 'DESC' ? 'DESC': 'ASC',

            'f' => $params['f'] ?? 'json'
        ];
    }   
    public function filter(array $params):array{
        $query = Status::query();
        $query->whereBetween('updated_at', [
            $params['from'],
            $params['to']
        ]);

        $query->orderBy('updated_at', $params['order']);

        if ($params['limit'] !== null) {
            $query->limit($params['limit']);
        }

        return $query->get()->toArray();
    }
}