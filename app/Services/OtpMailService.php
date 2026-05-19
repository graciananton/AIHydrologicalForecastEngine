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
    public function handleLogin(Request $request):void{
        if($this->userExists($request->email)){
            if(Auth::check()){

            }
            # user is not logged in
            else{
                # verificationsUpdateNums should be equal to 0 for next query to run
                $verificationUpdatedNumsAtBlockStart = User::where('email',$email)
                ->where('block_start_at','>',now()->addMinutes(-15));
                
                $verificationUpdatedNumsAtAttempts = User::where('email',$email)
                ->where(function ($query) {
                        $query->where('attempts_start_at', '<=', now()->addMinutes(-15))
                                ->where('attempts', '<', 5);
                    })
                    ->orWhere('attempts','<',5) ->update('block_start_at',now());

                if($verificationUpdatedNumsAtBlockStart != null && $verificationUpdatedNumsAtAttempts == 0){
                    $verificationUpdatedNums = User::where('email',$email)
                    ->where('last_sent_at','<=', now()->addSeconds(-3))
                    ->update([
                        'otp' => createOtp(),
                        'expires_at' => now().addMinutes(15),
                        'last_sent_at'=>now(),
                    ])
                    ->increment('attempts')
                    ->first();

                }
                else{
                    $status = 'cannot loggin for now, too many attempts';
                }
            }
        }
        else{
            // user does not exist
            try{
                $user = User::create([
                    'email' => $request->email
                ]);
                # since we are creating the user for the first time, set attempts = 1
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