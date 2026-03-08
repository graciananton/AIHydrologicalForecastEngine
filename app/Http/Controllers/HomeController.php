<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(Request $request){
    }
    public function process(){
        return view("home");
    }
}
