<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class OtpMailService{
    public function send_otp(string $email):bool{
        $otp = random_int(100000, 999999);
        $this->save_otp($otp, $email);
        try{
            Mail::to($email)->send(new OtpMail($otp));
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }
    public function save_otp(string $otp, string  $email):int{
        // if $record is null, no row contains this email address
        // if $record is not null, row does not contain this email address
        $record = DB::table('email_verifications')
        ->where('email', $email)
        ->first();

        if (!$record) {
            // if record is null, insert the new email address & otp
            DB::table('email_verifications')->insert([
                'email' => $email,
                'otp' => Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
                'verified' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return 1;
        } 
        else {
            // if record is not null, email address already exists, now two options
            //    -> email address already verified 
            //    -> email address not verified
            if (now()->lt($record->expires_at)) {
                // use existing otp, don't enter new otp
                DB::table('email_verifications')
                    ->where('email', $email)
                    ->update([
                        'attempts' => $record->attempts + 1,
                        'updated_at' => now()
                ]);
                return 2;
            } else {
                // enter new otp
                DB::table('email_verifications')
                    ->where('email', $email)
                    ->update([
                        'otp' => Hash::make($otp),
                        'expires_at' => now()->addMinutes(5),
                        'attempts' => 0,
                        'verified' => 0,
                        'updated_at' => now()
                    ]);
                return 3;
            }
        }
    }
    public function verify_otp(string $otp,string $email):bool{
        $record = DB::table('email_verifications')
        ->where('email', $email)
        ->first();
        if(Hash::check($otp, $record->otp)){
            return true;
        }
        else{
            return false;
        }
    }
}