<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Services\Formatter\ResponseFormatter;
use Illuminate\Support\Facades\Log;

class ResponseController extends Controller
{
    private ResponseService $ResponseService;
    private $params;
    public function __construct(ResponseService $ResponseService, Request $request){
        $this->ResponseService = $ResponseService;
        $this->params = $request;
    }
    public function process(){
       $this->params = $this->ResponseService->filter($this->params);
       Log::channel("laravel")->info($this->params['messages']);
       return response()->json($this->ResponseService->sync($this->params));
    }
}