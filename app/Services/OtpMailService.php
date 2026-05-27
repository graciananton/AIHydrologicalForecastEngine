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
use Illuminate\Validation\ValidationException;

class OtpMailService{
    public function validateRequest(Request $request):?bool{
        try{
            $request->validate([
                'email' => 'required|email:rfc,dns'
            ]);
            return true;
        }
        catch (ValidationException $e) {
            Log::error($e->getMessage());
            return $e->errors;
        }
    }
    public function handleLogin(Request $request){
        $response = $this->validateRequest($request);
        if($response){
            $user = $this->userExists($request->email);
            $emailVerification = $this->getEmailVerification($request->email);
            $otp = $this->createOtp();
            if($user != null){
                if(Auth::check()){
                    Log::channel('laravel')->info("Logged in successfully");
                    session([
                        'email' => $request->email
                    ]);

                    return (object) [
                        'success' => true,
                        'error' => null,
                        'loggedIn' => true,
                        'role'=> $user->role
                    ];
                }
                else{  
                    Log::channel("laravel")->info("account exists but not logged in");              
                    try{
                        Log::channel("laravel")->info("trying account");
                        Log::channel("laravel")->info($emailVerification->attempts_start_at);
                        Log::channel("laravel")->info("Current time");
                        Log::channel("laravel")->info(now());
                        if(
                            ($emailVerification->attempts_start_at->gte(now()->addMinutes(-15)) && $emailVerification->attempts >= 4)
                          ){
                            Log::channel("laravel")->info("Attempts happened in last 15 minutes");

                            return (object)[
                                'success' => false,
                                'role' =>  $user->role,
                                'loggedIn' => false,
                                'error' => 'Too many attempts, try again in a few minutes'
                            ];
                        }

                        if($emailVerification->attempts_start_at->lt(now()->addMinutes(-15))){
                            Log::channel("laravel")->info("Attempts did not happen in last 15 minutes");
                            $emailVerification->update([
                                'attempts' => 0,
                                'attempts_start_at' => now()
                            ]);
                        }


                        Log::channel("laravel")->info("Attempts is less than or equal to 4");

                        if($emailVerification->last_sent_at -> gt(now()->addSeconds(-3))){
                            return (object) [
                                'success' => false,
                                'role' => $user->role,
                                'loggedIn' => false,
                                'error' => 'Too many requests sent back to back to server, retry again'
                            ];
                        }

                        Log::channel("laravel")->info("Sending email  last sent at is good");

                        $verificationUpdatedRow = $emailVerification
                        ->update([
                            'otp' => $this->hashOtp($otp),
                            'expires_at' => now()->addMinutes(15),
                            'last_sent_at'=>now()
                        ]);

                        Log::channel("laravel")->info("Updated row otp, expires at, last sent at");

                        if($verificationUpdatedRow == 1){
                            $verificationUpdatedNums = $emailVerification
                            ->update([
                                'attempts' => $emailVerification->attempts + 1
                            ]);
                            Log::channel("laravel")->info("Attmets has incrmeented");
                        }

                        session([
                            'email' => $request->email
                        ]);
                        Log::channel('laravel')->info("Email addresss for requests - done");
                        Log::channel("laravel")->info(session('email'));


                        Log::channel("laravel")->info("before sending otp");

                        $result = $this->sendOtp($otp, $emailVerification);
                        if(!$result){
                            return (object) [
                                'success' => false,
                                'role' => $user->role,
                                'loggedIn' => false,
                                'error' => 'Could not send otp'
                            ];
                        }
                        Log::channel("laravel")->info("Sent OTP");

                        return (object) [
                            'success' => true,
                            'role' => $user->role,
                            'loggedIn' => false,
                            'error' => null
                        ];
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

                    $emailVerification = EmailVerifications::create([
                        'otp' => $this->hashOtp($otp),
                        'email' => $request->email,
                        'expires_at' => now()->addMinutes(15),
                        'last_sent_at' => now(),
                        'attempts_start_at' => now(),
                        'attempts' => 1
                    ]);

                    session([
                        'email' => $request->email
                    ]);
                    Log::channel("laravel")->info("Account created for the first time");
                    Log::channel("laravel")->info(session('email'));

                    $result = $this->sendOtp($otp, $emailVerification);

                    if(!$result){
                        return (object) [
                            'success' => false,
                            'role' => $user->role,
                            'loggedIn' => false,
                            'error' => 'Could not send otp'
                        ];
                    }

                    return (object) [ 
                        'success' => true,
                        'error' => null,
                        'loggedIn' => false,
                        'role' => $user->role
                    ];
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
            # assume user if invalid email address
            return (object) [
                'success' => false,
                'role' => 'user',
                'loggedIn' => false,
                'error' => "Incorrect email address"
            ];
        }
    }  
    // sendOtp needs to be updated in signature
    public function sendOtp($otp, $emailVerification):?bool{
        try{
            if($emailVerification != null){
                Log::channel("laravel")->info("Sending OTP address");
                Mail::to($emailVerification->email)->send(new OtpMail($otp));
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            Log::channel("laravel")->error(
                'Error when mailing otp to '.$emailVerification->email,
                $e->getMessage()
            );
            return false;
        }
    }
    public function verifyOtp($request){
        Log::channel("laravel")->info("Verifying the OTP");
        Log::channel("laravel")->info(session('email'));

        $emailVerification = $this->getEmailVerification(session('email'));
        $user = $this->userExists(session('email'));

        Log::channel("laravel")->info("Verifying Otp");
        Log::channel("laravel")->info($emailVerification->otp);
        Log::channel("laravel")->info($request->otp);

        if(Hash::check($request->otp, $emailVerification->otp)){   
            Log::channel("laravel")->info("User logging in");
            Auth::login($user);

            if(Auth::check()){
                Log::channel("laravel")->info("Logged in");
            }
            return (object) ['success' => true, 'role' => $user->role, 'user' => $user];
        }
        else{
            return (object) ['success' => false, 'role' => $user->role, 'user' => $user];
        }
    }
    public function joinOtp(Request $request){
        $pattern = "/box/";
        $otpSubmit = array();
        
        $otp = "";
        foreach($request->all() as $property => $value){
            if(preg_match($pattern, $property)){
                $otp .= trim($value);
            }
        }
        Log::channel("laravel")->info($otp);
        return $otp;
        //$otpSubmit['otp'] = $otp;
        //return (object) $otpSubmit;
    }
    private function extract_name_from_email(string $email):string{
        $pattern = "/@/";
        $parts = preg_split($pattern, $email);
        return ucfirst($parts[0]);
    } 
    private function getEmailVerification(string $email){
        try{
            $emailVerification = EmailVerifications::where('email',$email)->first();
        }
        catch(QueryException $e){
            Log::channel("laravel")->error(
                'Database query failed while creating retrieving email record.',
                $e->getMessage()
            );
        }
        catch(Exception $e){
            Log::channel("laravel")->error(
                'Unexpected error while retrieving email record.',
                $e->getMessage()
            );
        }
        return $emailVerification;
    }
    private function userExists(string $email):?User{
        try{
            $user = User::where('email',$email)->first();
        }
        catch(QueryException $e){
            Log::channel("laravel")->error(
                'Database query failed while creating retrieving email record.',
                $e->getMessage()
            );
        }
        catch(Exception $e){
            Log::channel("laravel")->error(
                'Unexpected error while retrieving email record.',
                $e->getMessage()
            );
        }
        return $user;
    }
    private function createOtp():int{
        return random_int(100000, 999999);
    }
    private function hashOtp($otp):string{
        return Hash::make($otp);
    }
}
