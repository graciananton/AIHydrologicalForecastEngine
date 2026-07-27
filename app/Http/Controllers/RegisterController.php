<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\RegisterService;
use App\Services\Formatter\ResponseFormatter;

class RegisterController extends Controller
{
    private array $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
    public function process(){
       $path = $request->option;
       if($path == "login"){
        return redirect('/login');
       }
       else if($path == "signup"){
        return redirect('/login');
       }
       else{
         return redirect()->back()->with('errors', 'Invalid Option Selected!');
       }
    }
}
