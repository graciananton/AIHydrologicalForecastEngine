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
        Log::channel("laravel")->info($request->email);
        Log::channel("laravel")->info($request->box1);
        Log::channel("laravel")->info($request->box2);
        Log::channel("laravel")->info($request->box3);
        Log::channel("laravel")->info($request->box4);
        Log::channel("laravel")->info($request->box5);
        Log::channel("laravel")->info($request->box6);

    }
    public function create_token($request){        
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return $token;
    }
}
