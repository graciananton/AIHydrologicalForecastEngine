<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\DailyReportService;

class DailyReportController extends Controller
{
    public function __construct(Request $request){
        
    }
    public function process(DailyReportService $dailyReportService){
        return $dailyReportService->sendDailyReport();
    }
}
