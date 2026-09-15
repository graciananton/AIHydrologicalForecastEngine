<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StationMessageDailyReportService;
use App\Models\User;
use App\Jobs\StationMessageDailyReportJob;

class StationMessageDailyReportController extends Controller
{
    public function __construct(Request $request){
        
    }
    public function sync(){
        $users = User::where('role','user')->get()->toArray();

        $string = "<pre>". print_r($users). "</pre>";
        
        Log::channel('laravel')->info($string);

        $results = [];
        foreach ($users as $user) {
            StationMessageDailyReportJob::dispatch($user);
        }
    }

}
