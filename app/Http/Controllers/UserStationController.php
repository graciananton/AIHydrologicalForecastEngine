<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class UserStationController extends Controller
{
    public function __construct(Request $request){
    }
    public function process(){
        return view("user.station", 
        [
            ['request' => 'userStation'],
            ['email' => session('email')]
        ]
        );
    }
}
