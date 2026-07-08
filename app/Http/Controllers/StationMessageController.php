<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StationService;
use App\Services\Formatter\ResponseFormatter;
use App\Services\ModelService;

class StationsController extends Controller{
    private array $params = [];
    private StationMessageService $StationMessageService;
    public function __construct(StationMessageService $StationMessageService, Request $request){
        $this->StationMessageService = $StationMessageService;
        $this->params = $this->StationMessageService->normalizeParams($request->query());
    }
    public function process(){
        $result = response()->json($this->StationMessageService->filter($this->params));
        return $result;
    }
    public function sync(){
        $stationIds = $this->ModelService->getStationIds();
        $results = [];
        foreach ($stationIds as $stationId) {
            StationMessageJob::dispatch($stationId);
        }
 
    }

}
