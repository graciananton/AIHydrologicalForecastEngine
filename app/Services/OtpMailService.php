<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;

class OtpMailService{
    public function handleLogin(Request $request){
        if($this->userExists($request->email)){

        }
        else{

        }
    }   
    private function userExists($email){
        $result = User::where('email',$email);
        
    }
}