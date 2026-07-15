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
        $createdAt = $user->created_at;

        Log::channel("laravel")->info("Email: " . $email);
        Log::channel("laravel")->info("created at: " . $createdAt);
        Log::channel("laravel")->info("station id: " . $stationId);

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
