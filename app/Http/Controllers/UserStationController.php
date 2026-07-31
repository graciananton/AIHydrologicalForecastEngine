<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserStationService;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserStationController extends Controller
{
    private $request;
    private $id;
    public function __construct(UserStationService $userStationService, Request $request){
        $this->request = $request;
        $this->id = $request->route('id', null);
    }
    public function process(UserStationService $userStationService){
        if($this->id != null){
            $stationId = $this->id;
        }
        else if(session()->has('email')){ // this checks if email property exists and is not null
            $user = $userStationService->getUser(session('email'));
            $stationId = $user->stationId;
        }
        else{ // if the session is not set, then
            $stationId = "02KF001";
        }

        Log::channel("laravel")->info("STATION ID: ".$stationId);

        return view("user.station", 
            [
            'request' => 'userStation',
            'email' => session('email'),
            'stationId' => $stationId
            ]
        );

    }
}
