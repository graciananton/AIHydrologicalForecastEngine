<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\LevelAnalysisService;
use App\Services\Formatter\ResponseFormatter;
use Illuminate\Support\Facades\Log;

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
       $result = $this->LevelAnalysisService->process($this->params);
       Log::channel("laravel")->info("Result: ");
       Log::channel("laravel")->info($result);
       
       return $result;
    }
}
