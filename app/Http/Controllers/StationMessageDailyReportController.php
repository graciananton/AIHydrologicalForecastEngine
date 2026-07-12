<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StationMessageDailyReportService;

class StationMessageDailyReportController extends Controller
{
    public function __construct(Request $request){
        
    }
    public function process(StationMessageDailyReportService $stationMessageDailyReportService){
        return $stationMessageDailyReportService->sendStationMessageDailyReport();
    }
}
