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
    public function loginSubmit(Request $request, OtpMailService $otpMailService){
        $otpMailService->handleLogin($request);
    }
    public function verificationCode(OtpMailService $otpMailService){
        Log::channel("laravel")->info("Redirecting to verification code page - verificationCode");
        $email = session('email');

        if($email){
            return view("auth.verificationCode");

            $otpMailService->sendOtp($email);
            Log::channel("laravel")->info("Sending otp in otpmailservice");
            #return view("auth.verificationCode", ['email' => $email]);
            return view("auth.verificationCode");
        }
    }
    public function create_token($request){        
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return $token;
    }
}
