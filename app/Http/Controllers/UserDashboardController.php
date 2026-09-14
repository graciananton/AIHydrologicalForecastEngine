<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserDashboardService;
use Illuminate\Support\Facades\DB;

class UserDashboardController{
    public function __construct(){

    }
    public function process(UserDashboardService $UserDashboardService){
        $email = session('email');
        $user = $UserDashboardService->getUser($email);
        
        $query =  "SELECT * FROM job_statuses WHERE type LIKE '%StationMessageJob%' AND created_at > (SELECT created_at FROM users WHERE email = ". $email.')';

        $jobs = DB::select($query);
        
        return response()->json($jobs);
        /*return view('user.userDashboard', [
            'jobs' => $jobs,
            'user' => $user
        ]);*/
    }
}