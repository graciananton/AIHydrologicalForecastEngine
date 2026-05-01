<?php
namespace App\Http\Controllers;
use App\Jobs\TrainModelJob;
use App\Services\ModelService;

class ModelController{
    private ModelService $ModelService;
    public function trainSingle(Request $request)
    {
        TrainModelJob::dispatch($request->stationId);

        return response()->json([
            'message' => 'Training started for station ' . $request->stationId
        ]);
    }

    public function trainAll(ModelService $ModelService)
    {
        $stationIds = $ModelService->getStationIds();

        foreach ($stationIds as $stationId) {
            TrainModelJob::dispatch($stationId);
        }

        return response()->json([
            'message' => 'Training started for all stations'
        ]);
    }
}
