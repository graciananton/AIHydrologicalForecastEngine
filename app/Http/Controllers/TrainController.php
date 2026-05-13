<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\TrainService;
use App\Services\Formatter\ResponseFormatter;

class TrainController extends Controller
{
    private array $params;
    private TrainService $TrainService;
    public function __construct(TrainService $TrainService, Request $request){
        $this->TrainService = $TrainService;
        $this->params = $this->TrainService->normalizeParams($request->query());
    }
    public function process(){
       return response()->json($this->TrainService->filter($this->params));
    }
}
