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
        if($user){
            return view("user.station", 
            [
                ['request' => 'userStation'],
                ['email' => session('email')],
                ['stationId' => $user->stationId]
            ]
            );
        }
        return view("user.station", 
            [
                ['request' => 'userStation'],
                ['email' => session('email')],
                ['stationId' => null]
            ]
        );

    }
}
