<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserStationService;
use Illuminate\Support\Facades\Log;

class UserStationController extends Controller
{
    public function __construct(Request $request){
    
    }
    public function process(UserStationService $userStationService){
        $user = $userStationService->getUser(session('email'));

        Log::channel("laravel")->info(($user) ?  "user is defined" :  "User not defined");
        Log::channel("laravel")->info("STATION ID: ".$user->stationId);

        return view("user.station", 
            [
            'request' => 'userStation',
            'email' => session('email'),
            'stationId' => ($user) ? $user->stationId : null
            ]
        );

    }
}
