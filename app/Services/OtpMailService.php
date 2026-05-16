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
    public function send_otp(string $emailAddress):array{
        Log::channel('laravel')->info("send_otp");
        Log::channel('laravel')->info("Email Address ". $emailAddress);

        $randomOtp = random_int(100000, 999999);

        $otpResult = $this->save_otp($randomOtp,$emailAddress);
        Log::channel("laravel")->info("Sent mail");
        Log::channel("laravel")->info("status => ". $otpResult['status']);
        Log::channel("laravel")->info("id => ". $otpResult['id']);

        try{
            if($otpResult['status']== true){
                Mail::to($emailAddress)->send(new OtpMail($randomOtp));
                Log::channel("laravel")->info("Sent mail");
                Log::channel("laravel")->info("status => ". $otpResult['status']);
                Log::channel("laravel")->info("id => ". $otpResult['id']);
                return ['id'=>$otpResult['id'],'success'=>$otpResult['status']];
            }
            else{
                return ['id'=>$otpResult['id'],'success'=>$otpResult['status']];
            }
        }
        catch(\Exception $e){
            return ['id'=>null,'success'=>false];
        }
    }
    public function save_otp(string $randomOtp,string $emailAddress):array{
        // if $record is null, no row contains this email address
        // if $record is not null, row does not contain this email address
        $record = DB::table('email_verifications')
            ->where('email', $emailAddress)
            ->first();

        if (!$record) {
            // row not yet created, first time user is requesting verification
            $id = DB::table('email_verifications')->insertGetId([
                'email' => $emailAddress,
                'otp' => Hash::make($randomOtp),
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
                'verified' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $status = 'created just now';
            $status = true;
        } 
        else {
            $id = $record->id;

            if (now()->lt($record->expires_at)) {
                // row created and not yet expired
                DB::table('email_verifications')
                    ->where('email', $emailAddress)
                    ->update([
                        'attempts' => $record->attempts + 1,
                        'updated_at' => now()
                    ]);
                $status = 'already sent, wait five minutes to try again';
                $status = false;
            } 
            else {
                // row created and expired
                // update otp and attempts
                DB::table('email_verifications')
                    ->where('email', $emailAddress)
                    ->update([
                        'otp' => Hash::make($randomOtp),
                        'expires_at' => now()->addMinutes(5),
                        'attempts' => $record->attempts + 1,
                        'verified' => 0,
                        'updated_at' => now()
                    ]);
                $status = 'created just now';
                $status = true;
            }
        }
        Log::channel("laravel")->info("Id => ". $id. "Status => ". $status);
        return ['id'=>$id,'status'=>$status];
    }
    public function verify_otp($userOtp,$id){
        $record = DB::table('email_verifications')
        ->where('id', $id)
        ->first();
        
        if(Hash::check($userOtp, $record->otp)){
            $result = DB::table('email_verifications')
            ->where('id', $id)
            ->update([
                'verified' => 1
            ]);

            if($result == 1){
                $record = DB::table('email_verifications')
                ->where('id', $id)
                ->first();
                return $record;
            }
        }
        else{
            return $record;
        }
    }
    public function addUser($record){
        $existing_record = User::where('email', $record->email)->first();
        try{
            if($existing_record){
                return false;
            }
            else{
                $result = User::create([
                    'name' => '',
                    'email' => $record->email,
                    'password' => $record->otp,
                    'remember_token' => false,
                    'email_verified_at' => now(),
                    'role' => 'user'
                ]);
                return true;
            }
        }
        catch(\Exception $e){
            Log::channel("laravel")->info((string)$e);
            return false;
        }
    }
}