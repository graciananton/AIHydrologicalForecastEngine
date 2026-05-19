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
    public function handleLogin(Request $request):RedirectResponse{
        $response = $this->validateRequest($request);
        if($response){
            $user = $this->userExists($request->email);
            $emailVerification = $this->getEmailVerification($request->email);
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
                        if($emailVerification->attempts_start_at >= now()->addMinutes(-15)){
                            return back()->withErrors([
                                'error' => 'Too many attempts, try again in a few minutes'
                            ]);
                        }
                        
                        if($emailVerification->attempts >= 4){
                            $user->update([
                                'attempts_start_at' => now(),
                                'attempts' => 0
                            ]);
                            return back()->withErrors([
                                'Too many attempts, try again in a few minutes'
                            ]);
                        }

                        if($emailVerification->last_sent_at > now()->addSeconds(-3)){
                            return back()->withErrors([
                                'Too many requests sent back to back to server, retry again'
                            ]);
                        }

                        $verificationUpdatedRow = $emailVerification
                        ->update([
                            'otp' => $this->createOtp(),
                            'expires_at' => now()->addMinutes(15),
                            'last_sent_at'=>now()
                        ]);

                        if($verificationUpdatedRow == 1){
                            $verificationUpdatedNums = $emailVerification
                            ->update([
                                'attempts' => $emailVerification->attempts + 1
                            ]);
                        }

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
        else{
            return back()->withErrors($response); 
        }
    }  
    public function sendOtp($email){
        try{
            $user = $this->userExists($email);
            if($user != null){
                Mail::to($email)->send(new OtpMail($user->otp));
            }
            else{
                // have some way to catch this error by sending redirect error back
            }
        }
        catch(Exception $e){
            Log::channel("laravel")->error(
                'Error when mailing otp to '.$email,
                $e->getMessage()
            );
        }
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
    private function createOtp():string{
        return Hash::make(random_int(100000, 999999));
    }
}