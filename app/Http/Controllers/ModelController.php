<?php
namespace App\Http\Controllers;
use App\Jobs\TrainModelJob;
use App\Jobs\TestModelJob;
use App\Jobs\FutureModelJob;

use App\Jobs\PlotTrainJob;
use App\Jobs\PlotTestJob;
use App\Jobs\PlotFutureJob;

use App\Services\ModelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModelController{
    private ModelService $ModelService;
    public function __construct(ModelService $ModelService){
        $this->ModelService = $ModelService;
    }
    // starting training model code
    public function trainSingle(Request $request)
    {
        TrainModelJob::dispatch($request->stationId);
        return response()->json([
            'message' => 'Training started for station ' . $request->stationId
        ]);
    }
    public function trainAll()
    {
        $stationIds = $this->ModelService->getStationIds();

        foreach ($stationIds as $stationId) {
            TrainModelJob::dispatch($stationId);
        }

        return response()->json([
            'message' => 'Training started for all stations'
        ]);
    }
    // end of training model code

    // start of plotTrain code
    public function plotTrainSingle(Request $request)
    {
        Log::channel("laravel")->info("Plotting train single");
        PlotTrainJob::dispatch($request->stationId);
        return response()->json([
            'message'=> sprintf('Plotted training data for station %s', $request->stationId)
        ]);
    }

    public function plotTrainAll()
    {
        Log::channel("laravel")->info("plotting training set all");
        $stationIds = $this->ModelService->getStationIds();

        foreach($stationIds as $stationId) {
            Log::channel("laravel")->info("Going thorugh stations");
            PlotTrainJob::dispatch($stationId);
        }
        return response()->json([
            'message' => 'Plotting training data started for all stations'
        ]);
    }
    // end of plotTrain code

    public function testSingle(Request $request)
    {
        try{
            $rmse = $this->ModelService->testModel($request->stationId);
            Log::channel("laravel")->info(sprintf("Test Single: %s RMSE score %f",$request->stationId, $rmse['RMSE']));
            return response()->json(['RMSE'=>$rmse['RMSE']]);
        }
        catch(\Throwable $e){
            Log::channel("laravel")->info($e->getMessage());
        }
    }
    public function testAll()
    {
        $stationIds = $this->ModelService->getStationIds();

        $results = [];
        foreach ($stationIds as $stationId) {
            try{
                TestModelJob::dispatch($stationId);
                //$rmse =  $this->ModelService->testModel($stationId);
                //$results[$stationId] = (float) $rmse['RMSE']; 
                //Log::channel("laravel")->info(sprintf("Test All: %s RMSE score %f",$stationId, $rmse['RMSE']));
            }
            catch(\Throwable $e){
                Log::channel("laravel")->info($e->getMessage());
            }
        }

        //return response()->json($results);
    }

    public function plotTestSingle(Request $request){
        Log::channel("laravel")->info("Plotting test single");
        PlotTestJob::dispatch($request->stationId);
        return response()->json([
            'message' => sprintf('Plotted test data for station %s', $request->stationId)
        ]); 
    }

    public function plotTestAll()
    {
        $stationIds = $this->ModelService->getStationIds();

        foreach($stationIds as $stationId) {
            PlotTestJob::dispatch($stationId);
        }
        return response()->json([
            'message' => 'Plotting test data started for all stations'
        ]);
    }

    public function plotFutureSingle(Request $request)
    {
        Log::channel("laravel")->info("Plotting future single");
        PlotFutureJob::dispatch($request->stationId);
        return response()->json([
            'message'=> sprintf('Plotted future data for station %s', $request->stationId)
        ]);
    }

    public function plotFutureAll()
    {
        $stationIds = $this->ModelService->getStationIds();

        foreach($stationIds as $stationId) {
            PlotFutureJob::dispatch($stationId);
        }
        return response()->json([
            'message' => 'Plotting future data started for all stations'
        ]);
    }




    public function pastSetSingle(Request $request){
        $predictions = $this->ModelService->pastSet($request->stationId);
        return response()->json($predictions);
    }
    public function pastSetAll(){
        $stationIds = $this->ModelService->getStationIds();
        $results = [];
        foreach ($stationIds as $stationId) {
           $pastPredictions =  $this->ModelService->pastSet($stationId);
           $results[$stationId] = $pastPredictions; 
        }
        return response()->json($results);

    }

    public function futureSetSingle(Request $request)
    {
        $predictions = $this->ModelService->futureSet($request->stationId);
        return response()->json($predictions);
    }
    public function futureSetAll(){
        $stationIds = $this->ModelService->getStationIds();
        $results = [];
        foreach ($stationIds as $stationId) {
            FutureModelJob::dispatch($stationId);
            //$futurePredictions =  $this->ModelService->futureSet($stationId);
            //Log::channel("laravel")->info("future Predictions for ".$stationId);
            //$results[$stationId] = $futurePredictions; 
        }
        //return response()->json($results);
    }
}
