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
    public function signup():View{
        return view("auth.signup");
    }
    public function signupSubmit(Request $request, OtpMailService $otpMailService){
        $result = $otpMailService->handleSignup($request);
        if($result->success){
            return redirect('/verificationCode');
        }
        else{
            return redirect('/signup')->with('error', $request->error);
        }
    }
    public function loginSubmit(Request $request, OtpMailService $otpMailService){
        Log::channel("laravel")->info("logging submit");
        $result = $otpMailService->handleLogin($request);
        Log::channel("laravel")->info("Request type " . $request->accept);
        if($request->accept == "json"){
            return $result;
        }
        else{
            if($result->success && !$result->loggedIn){
                Log::channel("laravel")->info("Not logged in but result is true");
                return redirect('/verificationCode');
            }
            else if(!$result->success){
                return redirect('/login')->with('error', $request->error);
            }
            else if($result->success && $result->loggedIn){
                if($result->role == 'admin'){
                    return redirect('/dashboard');
                }
                else if($result->role == 'user'){
                    return redirect('/userStation');
                }
            }
        }
    }
    public function verificationCode():View{
        return view("auth.verificationCode");
    }
    public function verificationCodeSubmit(Request $request, OtpMailService $otpMailService){
        if($request->accept == "json"){
            $request->otp = $request->verificationCode;
        }
        else{
            $request->otp = $otpMailService->joinOtp($request);
        }

        $result = $otpMailService->verifyOtp($request);

        if($request->accept == "json"){
            return $result;
        }
        else{
            if($result->success){
                if($result->role == "admin"){
                    return redirect('/dashboard');
                }
                else if($result->role == "user"){
                    return redirect("/userStation");
                }
            }
            else{
                return redirect('/verificationCode')->with('error', 'Incorrect verification code entered.');
            }
        }
    }
    public function create_token($request){        
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return $token;
    }
}
