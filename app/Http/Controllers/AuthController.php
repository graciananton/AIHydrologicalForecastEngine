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
    public function verification_code(){
        $email = session('email');
        return view("auth.verification_code", ['email' => $email]);
    }
    public function create_token($request){        
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return $token;
    }

}
