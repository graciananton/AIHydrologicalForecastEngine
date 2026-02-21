<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\LogService;

class LogController extends Controller
{
    private LogService $LogService;
    private string $numberOfLogs;
    public function __construct(){
        $this->LogService = $LogService;
        $this->numberOfLogs = $request->only('numberOfLogs');
    }
    public function process(){
        return response()->json(
            ["numberOfLogs"=>"15"]
        );

        Log::channel("laravel")->info("LogController running");
        $logs = $this->LogService->fetchLogs($this->numberOfLogs);
        return $logs;
    }
}