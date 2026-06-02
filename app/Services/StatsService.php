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

        Log::channel("laravel")->info("predictions count");
        Log::channel("laravel")->info(count($predictions));

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
        
        
        // it must have at least 2 predictions, or else just choose the first prediction
        if(count($predictions) >= 2){
            $latestFuturePrediction = $predictions[count($predictions) - 1];
        }
        else{
            $latestFuturePrediction = $predictions[0];
        }

        $oldestFuturePrediction = $predictions[0];

        return [
            'currentLevel' => $currentLevel->prediction,
            'trend' => ($latestFuturePrediction->prediction - $oldestFuturePrediction->prediction > 0.0) ? "rising": "falling",
            'lastUpdated' => $latestFuturePrediction->updated_at,
            'maximumForecast' => $maxPrediction->prediction,
            'minForecast' => $minPrediction->prediction,
            'maximumForecast' => $maxPrediction->prediction,
            'peakTime' => $maxPrediction->updated_at,
            'change' => $latestFuturePrediction->prediction - $oldestFuturePrediction->prediction
        ];
    }   
}