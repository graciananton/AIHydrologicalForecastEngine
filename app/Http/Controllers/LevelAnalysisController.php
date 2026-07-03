<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\LevelService;
use App\Services\Formatter\ResponseFormatter;

class LevelAnalysisController extends Controller
{
    private array $params;
    private LevelAnalysisService $LevelAnalysisService;
    private $request;
    public function __construct(LevelAnalysisService $LevelAnalysisService, Request $request){
        $this->LevelAnalysisService = $LevelAnalysisService;
        $this->request = $request;
        $this->params = $this->LevelAnalysisService->normalizeParams($request->query());
    }
    public function process(){
       return response()->json($this->LevelAnalysisService->filter($this->params));
    }
    public function sync(){
        if($this->LevelAnalysisService->sync($this->request->stationId)){
            return response()->json([
                'message' => sprintf('Inserted levels for station %s', $this->request->stationId)
            ]); 
        }
        else{
            return response()->json([
                'message' => sprintf('Inserted levels for station %s', $this->request->stationId)
            ]); 
        }

    }
}
