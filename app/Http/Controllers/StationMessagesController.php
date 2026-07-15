<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserStationService;
use Illuminate\Support\Facades\Log;

class StationMessagesController extends Controller
{
    public function __construct(Request $request){
    
    }
    public function process(){
        return view("user.messages", 
            [
            'request' => 'stationMessages',
            'email' => session('email'),
            ]
        );

    }
}
