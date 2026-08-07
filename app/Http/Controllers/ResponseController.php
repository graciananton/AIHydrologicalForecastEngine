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
       Log::channel("weather")->info("ResponseController - paramsslldljk;sdlkj;dsk;lsl;k");
       
       $messages = $this->params->messages;
       Log::channel("weather")->info($messages);
       
       return response()->json($this->ResponseService->sync($this->params));
    }
}