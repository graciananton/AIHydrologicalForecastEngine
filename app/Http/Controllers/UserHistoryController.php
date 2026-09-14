<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserHistoryService;
use Illuminate\Support\Facades\DB;

class UserDashboardController{
    public function __construct(){

    }
    public function process(){
        $email = session('email');

        $user = $UserDashboardService->getUser($email);
        
        $query =  "SELECT * FROM job_statuses WHERE type LIKE '%StationMessageJob%' AND created_at > (SELECT created_at FROM users WHERE email = ". $email.')';

        $jobs = DB::select($query);
        
        $route = request()->segment(2);

        if($route == "jobs"){
            return response()->json($jobs);
        }
        else if($route == "user"){
            return response()->json($user);
        }  
    }
}