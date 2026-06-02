<?php
namespace App\Services;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class StatsService
{
    public function normalizeParams(array $params): array{
        $params = [
            'stationId' => $params['stationId'] ?? "",
            'f' => $params['f'] ?? 'json'
        ];
        return $params;
    }
    public function filter(array $params):array{
        $hour = Carbon::now('UTC')->startOfHour();
        $level = "http://gracian.ca/laravel/public/api/future?stationId=".$params['stationId']."&from=".$hour."&to=".$hour;
        
        Log::channel("laravel")->info($level);
        
        $response = Http::get($level);

        $data = $response->json();

        return $data;
    }
}