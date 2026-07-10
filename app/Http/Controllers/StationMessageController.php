<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StationService;
use App\Services\Formatter\ResponseFormatter;
use App\Services\StationMessageService;
use App\Services\ModelService;

use App\Jobs\StationMessageJob;

class StationMessageController extends Controller{
    private array $params = [];
    private StationMessageService $StationMessageService;
    private ModelService $ModelService;

    public function __construct(ModelService $ModelService, StationMessageService $StationMessageService, Request $request){
        $this->StationMessageService = $StationMessageService;
        $this->ModelService = $ModelService;
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
