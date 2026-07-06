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
       return response()->json($this->LevelAnalysisService->sync($this->params));
    }
}
