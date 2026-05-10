<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PredictionsService;
use App\Services\Formatter\ResponseFormatter;

class PredictionsController extends Controller
{
    private array $params;
    private PredictionsService $PredictionsService;
    public function __construct(PredictionsService $PredictionsService, Request $request){
        $this->PredictionsService = $PredictionsService;
        $this->params = $this->PredictionsService->normalizeParams($request->query());
    }
    public function process(){
       return response()->json($this->PredictionsService->filter($this->params));
    }
}
