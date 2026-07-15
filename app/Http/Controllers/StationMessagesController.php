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
        $createdAt = User::where('email', session('email'))->get('created_at');

        return view("user.messages", 
            [
            'request' => 'stationMessages',
            'email' => session('email'),
            'createdAt' => $createdAt
            ]
        );

    }
}
