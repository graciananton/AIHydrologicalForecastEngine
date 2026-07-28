<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\RegisterService;
use App\Services\Formatter\ResponseFormatter;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    private $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
    public function process(){
       $path = $this->request->option;

       if($path == "login"){
        return redirect('/login');
       }
       else if($path == "signup"){
        return redirect('/signup');
       }
       else{
         return redirect()->back()->with('error', 'Invalid option selected, select one of the two options listed below.');
       }
    }
}
