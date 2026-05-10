<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\TestEvaluationsService;
use App\Services\Formatter\ResponseFormatter;

class TestEvaluationsController extends Controller
{
    private array $params;
    private TestEvaluationsService $TestEvaluationsService;
    public function __construct(TestEvaluationsService $TestEvaluationsService, Request $request){
        $this->TestEvaluationsService = $TestEvaluationsService;
        $this->params = $this->TestEvaluationsService->normalizeParams($request->query());
    }
    public function process(){
       return response()->json($this->TestEvaluationsService->filter($this->params));
    }
}
