<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\EmailVerifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class OtpMailService{
    public function handleLogin(Request $request):RedirectResponse{
        $user = $this->userExists($request->email);
        if($user != null){
            if(Auth::check()){
                if($user->role == 'admin'){
                    return redirect('/dashboard');
                }
                else{
                    return redirect('/userAccount');
                }
            }
            else{                
                try{
                    $verificationUpdatedNumsAtAttempts = User::where('email',$request->email)
                    ->where('attempts_start_at', '>=', now()->addMinutes(-15))
                    ->where('attempts', '>=', 4)
                    ->update([
                            'attempts_start_at' => now(),
                            'attempts' => 0
                    ]);

                    if($verificationUpdatedNumsAtAttempts == 0){
                        $verificationUpdatedRow = User::where('email',$request->email)
                        ->where('last_sent_at','<=', now()->addSeconds(-3))
                        ->update([
                            'otp' => createOtp(),
                            'expires_at' => now()->addMinutes(15),
                            'last_sent_at'=>now()
                        ]);

                        if($verificationUpdatedRow == 1){
                            $verificationUpdatedNums = User::where('email',$request->email)
                            ->increment('attempts');
                        }
                        session([
                            'email' => $request->email
                        ]);
                        return redirect('/verificationCodes');
                    }
                    else{
                        return back()->withErrors([
                            'error' => 'Too many attempts, try again in a few minutes'
                        ]);
                    }
                }
                catch(QueryException $e){
                    Log::channel("laravel")->error(
                        'Database query failed while creating OTP record.',
                        $e->getMessage()
                    );
                }
                catch(Exception $e){
                    Log::channel("laravel")->error(
                        'Unexpected OTP service error.',
                        $e->getMessage()
                    );
                }
            }
        }
        else{
            try{
                $user = User::create([
                    'email' => $request->email,
                    'name' => $this->extract_name_from_email($request->email),
                    'role' => 'user'
                ]);

                $verification = EmailVerifications::create([
                    'otp' => $this->createOtp(),
                    'email' => $request->email,
                    'expires_at' => now()->addMinutes(15),
                    'last_sent_at' => now(),
                    'attempts_start_at' => now(),
                    'attempts' => 1
                ]);

                session([
                    'email' => $request->email
                ]);

                return redirect('/verificationCode');
            }
            catch(QueryException $e){
                Log::channel("laravel")->error(
                    'Database query failed while creating OTP record.',
                    $e->getMessage()
                );
            }
            catch(Exception $e){
                Log::channel("laravel")->error(
                    'Unexpected OTP service error.',
                    $e->getMessage()
                );
            }
        }
    }  
    public function sendOtp($email){
        
    }
    private function extract_name_from_email(string $email):string{
        $pattern = "/@/";
        $parts = preg_split($pattern, $email);
        return ucfirst($parts[0]);
    } 
    private function userExists(string $email):?User{
        $user = User::where('email',$email)->first();
        return $user;
    }
    private function createOtp():string{
        return Hash::make(random_int(100000, 999999));
    }
}