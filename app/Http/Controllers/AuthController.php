<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
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
            $token = $this->create_token($request);
            session(['api_token'=>$token]);
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
    public function signup(){
        return view("auth.signup");
    }
    public function signup_submit(Request $request){
        $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'string|required|email|unique:users,email',
            'password' => 'string|required|min:4|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/login')->with('success','Account created successfully! \n Now re-login');
    }
}
