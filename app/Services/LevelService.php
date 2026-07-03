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
            'stationId' => $params['stationId'] ?? '02KF001'
        ];
    }   
    public function filter(array $params):array{
        $query = Levels::query();

        $query->where('stationId', $params['stationId']);
        return $query->get()->toArray();
    }
}