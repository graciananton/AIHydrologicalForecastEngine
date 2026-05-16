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
            'email' => 'required|email'
        ]);
        #if(Auth::attempt($credentials)){
        if($this->userExists($request)){
            $request->session()->regenerate();
            $request->session()->put('email', $request->email);
            return redirect('/verification_code');
        }
        else{
            return redirect()->back()->with('error', 'Unsuccessful Login Attempt');
        }
    }
    public function userExists($request):bool{
        $user = User::where('email', $request->email)->first();

        return (bool) $user;
    }
    public function verification_code(){
        $email = session('email');
        Log::channel('laravel')->info('verification code');
        return view("auth.verification_code", ['email' => $email]);
    }
    public function create_token($request){        
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return $token;
    }

    public function request_otp(Request $request, OtpMailService $otpMailService ){
        $result = $otpMailService->send_otp($request->email_address);
        if($result['success'] == true){
            return response()->json([
                'success' => true,
                'id' => $result['id']
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'id' => $result['id']
            ]);
        }
    }
    public function request_verify_otp(Request $request, OtpMailService $otpMailService){
        $record = $otpMailService->verify_otp($request->verification_code, $request->id);
        if($record->verified == 1){
            if($otpMailService->addUser($record)){
                return response()->json([
                    'success' => true
                ]);
            }

            Log::channel("laravel")->info("verified but already created user");
            return response()->json([
                'success' => false
            ]);
        }
        else{
            Log::channel("laravel")->info("not verified");
            return response()->json([
                'success' => false
            ]);
        }
    }
}
