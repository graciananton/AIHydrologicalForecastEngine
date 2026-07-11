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

        $futureHour = Carbon::now('UTC')->startOfHour()->addHours(48);

        $predictions = Predictions::where('stationId', $params['stationId'])
            ->whereBetween('predictedFor', [$currentHour, $futureHour])
            ->orderBy('prediction', 'desc')
            ->get()
            ->take(48)
            ;

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
        
        /*$url = "http://gracian.ca/laravel/public/api/levelAnalysis?stationId=".$params['stationId']."&level=".$currentLevel->prediction."
                               &time=".$currentHour."&mode=percentile";

        Log::channel("laravel")->info("URL:");
        Log::channel("laravel")->info($url);
        $currentLevelStatus = Http::get($url);
        $currentLevelPercentile = $currentLevelStatus['percentile'];
        */
        // it must have at least 2 predictions, or else just choose the first prediction

        $sumPercentiles = 0;
        foreach ($predictions as $prediction){
            $sumPercentiles += $prediction['percentile'];
        }

        $meanPercentile = $sumPercentiles/count($predictions);

        if(count($predictions) >= 2){
            $latestFuturePrediction = $predictions[count($predictions) - 1];
        }
        else{
            $latestFuturePrediction = $predictions[0];
        }

        $oldestFuturePrediction = $predictions[0];
        
        
        
        return [
            'currentLevel' => $currentLevel->prediction,
            'meanPercentile' => $meanPercentile,
            'meanStatus' => $this->classify($meanPercentile),
            'trend' => ($latestFuturePrediction->prediction - $oldestFuturePrediction->prediction > 0.0) ? "rising": "falling",
            'change' => $latestFuturePrediction->prediction - $oldestFuturePrediction->prediction,
            'lastUpdated' => $latestFuturePrediction->updated_at,
            'maximumForecast' => $maxPrediction->prediction,
            'minForecast' => $minPrediction->prediction,
            'peakTime' => $maxPrediction->updated_at
        ];
    }   
    private function classify($percentile){
        return match(true){
            $percentile < 25 => "lower than usual",
            $percentile < 65 => "normal",
            $percentile < 80 => "above normal",
            default => "extremely high"
        };
    }
}