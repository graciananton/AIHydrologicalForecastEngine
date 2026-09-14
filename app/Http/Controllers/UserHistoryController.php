<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\UserHistoryService;

class UserHistoryController{
    public function __construct(){

    }
    public function process(UserHistoryService $UserHistoryService){
        $email = session('email');

        $user = $UserHistoryService->getUser($email);
        
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