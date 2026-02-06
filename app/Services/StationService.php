<?php
namespace App\Services;
use App\Models\Station;
use Carbon\Carbon;

class StationService
{
    public function normalizeParams(array $params): array{
        $params = [
            'stationId' => $params['stationId'] ?? "",
            'province' => $params['province'] ?? "",
            'f' => $params['f'] ?? 'json'
        ];
        return $params;
    }
    public function filter(array $params):array{
        $query = Station::query(); # SELECT * FROM stations
        
        if(array_key_exists('stationId',$params) && $params['stationId'] != ""){
            $query->where('stationId',$params['stationId']);
        }
        if(array_key_exists('province',$params) && $params['province'] != ""){
            $query->where('province',$params['province']);
        }

        return $query->get()->toArray();
    }
}