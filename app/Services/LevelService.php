<?php
namespace App\Services;

use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
}