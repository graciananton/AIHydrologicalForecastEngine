<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\OtpMailService;
use Illuminate\View\View;

class AuthController extends Controller
{
    private OtpMailService $otpMailService;
    public function login():View{
        return view("auth.login");
    }
    public function loginSubmit(Request $request, OtpMailService $otpMailService){
        $otpMailService->handleLogin($request);
        return redirect("http://localhost/laravel/public/verificationCode");
    }
    public function verificationCode():View{
        Log::channel("laravel")->info("Redirecting to verification code page - verificationCode");
        return view("auth.verificationCode");
    }
    public function verificationCodeSubmit(Request $request){
        $otpSubmit = $otpMailService->joinOtp($request);

        $otpMailService->verifyOtp($otpSubmit);
    }
    public function create_token($request){        
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return $token;
    }
}
