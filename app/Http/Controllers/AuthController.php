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
    public function login_submit(Request $request, OtpMailService $otpMailService){
        $credentials = $request->validate([
            'email' => 'required|email'
        ]);
        if($this->userExists($request)){
            Log::channel("laravel")->info("user exists");
            $request->session()->regenerate();
            $request->session()->put('email', $request->email);

            $response = $otpMailService->send_otp($request->email, $otpMailService);
            
            if($response['success']){
                Log::info("User exists, sent verification code successfully");
                return redirect('/verification_code');
            };
            return redirect()->back()->with('error', 'Unsuccessful Login Attempt');
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
        return view("auth.verification_code", ['email' => $email]);
    }
    public function create_token($request){        
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return $token;
    }

    public function request_otp(Request $request, OtpMailService $otpMailService){
        $result = $otpMailService->send_otp($request->email);
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
    public function verification_code_submit(Request $request, OtpMailService $otpMailService){
        $id = $otpMailService->getVerificationIdByEmail(session('email'));
        if(!$id){
            return redirect()->back()->with("error","Unsuccessfull Attempt");
        }
        $verification_code = $otpMailService->joinUserOtp($request);
        
        $record = $otpMailService->verify_otp($verification_code, $id);

        $user = $otpMailService->getUserByEmail(session('email'));

        if($record->verified == 1){
            # check the roles and send to redirect dashboard or user page based on middleware
            if($user->role == 'admin'){
                $request->session()->put('role','admin');
                return redirect("/workflow");
            }
            else if($user->role  == 'user'){
                $request->session()->put('role','user');
                return redirect("/dashboard");
            }
        }
        return redirect()->back()->with("error","Unsuccessfull Attempt");
    }
    public function request_verify_otp(Request $request, OtpMailService $otpMailService){
        Log::channel("laravel")->info("requesting to verify otp");

        $record = $otpMailService->verify_otp($request->verification_code, $request->id);
        Log::channel("laravel")->info("Verified: ".$record->verified);
        if($record->verified == 1){
            if($otpMailService->addUser($record)){
                return response()->json([
                    'role' => $record->role,
                    'success' => true
                ]);
            }

            return response()->json([
                'success' => false
            ]);
        }
        else{
            return response()->json([
                'success' => false
            ]);
        }
    }
}
