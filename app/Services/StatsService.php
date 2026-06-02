<?php
namespace App\Services;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Predictions;

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
        //$hour = Carbon::now('UTC')->startOfHour()->format('Y-m-d\TH:i:s.u\Z');

        $currentHour = Carbon::now('UTC')->startOfHour();
        $futureHour = Carbon::now('UTC')->startOfHour()->addHours(24);

        $predictions = Predictions::where('stationId', $params['stationId'])
            ->whereBetween('predictedFor', [$currentHour, $futureHour])
            ->orderBy('predictedFor','asc')
            ->get();

        return $predictions;
    }   
}