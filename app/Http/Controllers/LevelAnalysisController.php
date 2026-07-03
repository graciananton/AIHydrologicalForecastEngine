<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\LevelService;
use App\Services\Formatter\ResponseFormatter;

class LevelAnalysisController extends Controller
{
    private array $params;
    private LevelAnalysisService $LevelService;
    private $request;
    public function __construct(LevelService $LevelService, Request $request){
        $this->LevelService = $LevelService;
        $this->request = $request;
        $this->params = $this->LevelService->normalizeParams($request->query());
    }
    public function process(){
       return response()->json($this->LevelService->filter($this->params));
    }
    public function sync(){
        if($this->LevelService->sync($this->request->stationId)){
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
