<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StationMessageDailyReportService;

class StationMessageDailyReportController extends Controller
{
    public function __construct(Request $request){
        
    }
    public function sync(){
        $users = User::where('role','user')->get()->toArray();
        $results = [];
        foreach ($users as $user) {
            StationMessageDailyReportJob::dispatch($user);
        }
    }

}
