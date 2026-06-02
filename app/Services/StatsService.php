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
        $currentHour = Carbon::now('UTC')->startOfHour();
        $futureHour = Carbon::now('UTC')->startOfHour()->addHours(24);

        $predictions = Predictions::where('stationId', $params['stationId'])
            ->whereBetween('predictedFor', [$currentHour, $futureHour])
            ->orderBy('prediction', 'desc')
            ->get();

        $maxPrediction = Predictions::where('stationId', $params['stationId'])
            ->whereBetween('predictedFor', [$currentHour, $futureHour])
            ->orderBy('prediction', 'desc')
            ->first();

        $minPrediction = Predictions::where('stationId', $params['stationId'])
            ->whereBetween('predictedFor', [$currentHour, $futureHour])
            ->orderBy('predictedFor','asc')
            ->first();

        $currentLevel = Predictions::where('stationId', $params['stationId'])
            ->where('predictedFor', $currentHour)
            ->first();
        
        
        return [
            'currentLevel' => $currentLevel->prediction,
            'trend' => ($predictions[count($predictions)-1]->prediction - $predictions[0]->prediction > 0.0) ? "rising": "falling",
            'lastUpdated' => $prediction[count($predictions)-1]->updated_at,
            'maximumForecast' => $maxPrediction->prediction,
            'minForecast' => $minPrediction->prediction,
            'maximumForecast' => $maxPrediction->prediction,
            'peakTime' => $maxPrediction->updated_at,
            'change' => $predictions[count($predictions)-1]->prediction - $predictions[0]->prediction
        ];
    }   
}