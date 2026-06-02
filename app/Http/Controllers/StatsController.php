<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StatsService;
use App\Services\Formatter\ResponseFormatter;

class StatsController extends Controller
{
    private array $params;
    private StatsService $StatsService;
    public function __construct(StatsService $StatsService, Request $request){
        $this->StatsService = $StatsService;
        $this->params = $this->StatsService->normalizeParams($request->query());
    }
    public function process(){
       return response()->json($this->StatsService->filter($this->params));
    }
}
