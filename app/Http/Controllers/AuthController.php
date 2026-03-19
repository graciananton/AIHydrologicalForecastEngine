<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\OtpMailService;

class AuthController extends Controller
{
    private OtpMailService $otpMailService;
    public function login(){
        return view("auth.login");
    }
    public function login_submit(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            //$token = $this->create_token($request);
            //session(['api_token'=>$token]);
            return redirect('/status');
        }
        else{
            return redirect()->back()->with('error', 'Unsuccessful Login Attempt');
        }
    }
    public function create_token($request){        
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return $token;
    }

    public function request_otp(Request $request){
        $this->otpMailService = new otpMailService($request->email_address);
        if($this->otpMailService->send_otp()){
            return response()->json([
                'success' => true
            ]);
        }
        else{
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function request_verify_otp(Request $request){
        $this->otpMailService = new otpMailService($request->otp);
        // checks if user otp and saved otp match
        if($this->otpMailService->verify_otp()){
            return response()->json([
                'success' => true
            ]);
        }
        else{
            return response()->json([
                'success' => false
            ]);
        }
    }
}
