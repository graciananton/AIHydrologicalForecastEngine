<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserStationService;

class UserStationController extends Controller
{
    public function __construct(Request $request){
    
    }
    public function process(UserStationService $userStationService){
        $user = $userStationService->getUser(session($email));
        return view("user.station", 
            [
                ['request' => 'userStation'],
                ['stationId' => ($user) ? $user->stationId : null]
            ]
        );

    }
}
