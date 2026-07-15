<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserStationService;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class StationMessagesController extends Controller
{
    public function __construct(Request $request){

    }
    public function process(){
        $email = session('email');
        $user = User::where('email', session('email'))->first();
        $stationId = $user->stationId;
        $createdAt = $user->createdAt;

        return view("user.messages", 
            [
            'request' => 'stationMessages',
            'email' => $email,
            'createdAt' => $createdAt,
            'stationId' => $stationId,
            ]
        );

    }
}
