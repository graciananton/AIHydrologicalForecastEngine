<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\UserHistoryService;

class UserHistoryController{
    public function __construct(){

    }
    public function process(){
        $UserHistoryService = new UserHistoryService(session('email'));

        $user = $UserHistoryService->getUser();
        
        $jobs = $UserHistoryService->getJobs();

        $route = request()->segment(2);

        return ($route == "jobs") ? response()->json($jobs) : (($route == "user") ? response()->json($user) : response()->json(new \stdClass()));
    }
}