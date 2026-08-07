<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Services\Formatter\ResponseFormatter;

class ResponseController extends Controller
{
    private array $params;
    private ResponseService $ResponseService;
    private $request;
    public function __construct(ResponseService $ResponseService, Request $request){
        $this->ResponseService = $ResponseService;
        $this->request = $request;
    }
    public function process(){
       return response()->json($this->ResponseService->process($this->request));
    }
}