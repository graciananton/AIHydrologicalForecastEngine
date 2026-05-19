<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;

class OtpMailService{
    public function handleLogin(Request $request):string{
        if($this->userExists($request->email)){
            if(Auth::check()){
                redirect('/dashboard');
            }
            else{                
                try{
                    $verificationUpdatedNumsAtAttempts = User::where('email',$email)
                    ->where('attempts_start_at', '>=', now()->addMinutes(-15))
                    ->where('attempts', '>=', 4)
                    ->update([
                            'attempts_start_at' => now(),
                            'attempts' => 0
                    ]);

                    if($verificationUpdatedNumsAtAttempts == 0){
                        $verificationUpdatedRow = User::where('email',$email)
                        ->where('last_sent_at','<=', now()->addSeconds(-3))
                        ->update([
                            'otp' => createOtp(),
                            'expires_at' => now()->addMinutes(15),
                            'last_sent_at'=>now()
                        ]);

                        if($verificationUpdatedRow == 1){
                            $verificationUpdatedNums = User::where('email',$email)
                            ->increment('attempts');
                        }
                        return true;
                    }
                    else{
                        return false;
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
                    'email' => $request->email
                ]);

                $verification = EmailVerifications::create([
                    'otp' => $this->createOtp(),
                    'email' => $request->email,
                    'expires_at' => now()->addMinutes(15),
                    'last_sent_at' => now(),
                    'attempts_start_at' => now(),
                    'attempts' => 1,
                    'block_start_at' => null
                ]);
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
    private function userExists(string $email):bool{
        $user = User::where('email',$email)->first();
        return ($user) ? true:false;
    }
    private function createOtp():int{
        return Hash::make(random_int(100000, 999999));
    }
}