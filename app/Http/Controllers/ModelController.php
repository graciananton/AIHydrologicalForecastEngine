<?php
namespace App\Http\Controllers;
use App\Jobs\TrainModel;

class ModelController{
    public function trainSingle(Request $request)
    {
        TrainModelJob::dispatch($request->stationId);

        return response()->json([
            'message' => 'Training started for station ' . $request->stationId
        ]);
    }

    public function trainAll()
    {
        $stationIds = get_stations();

        foreach ($stationIds as $stationId) {
            TrainModelJob::dispatch($stationId);
        }

        return response()->json([
            'message' => 'Training started for all stations'
        ]);
    }
}
