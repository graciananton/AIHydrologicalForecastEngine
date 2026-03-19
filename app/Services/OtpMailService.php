<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpMailService{
    public function send_otp($emailAddress):bool{
        $randomOtp = random_int(100000, 999999);
        $id = $this->save_otp($randomOtp,$emailAddress);
        try{
            Mail::to($emailAddress)->send(new OtpMail($randomOtp));
            return ['id'=>$id,'success'=>true];
        }
        catch(\Exception $e){
            return ['id'=>null,'success'=>false];
        }
    }
    public function save_otp($randomOtp,$emailAddress):int{
        // if $record is null, no row contains this email address
        // if $record is not null, row does not contain this email address
        $record = DB::table('email_verifications')
        ->where('email', $emailAddress)
        ->first();

        if (!$record) {
            // if record is null, insert the new email address & otp
            $record = DB::table('email_verifications')->insert([
                'email' => $emailAddress,
                'otp' => Hash::make($randomOtp),
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
                'verified' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        else {
            // if record is not null, email address already exists, now two options
            //    -> email address already verified 
            //    -> email address not verified
            if (now()->lt($record->expires_at)) {
                // use existing otp, don't enter new otp
                DB::table('email_verifications')
                    ->where('email', $emailAddress)
                    ->update([
                        'attempts' => $record->attempts + 1,
                        'updated_at' => now()
                ]);
            } else {
                // enter new otp
                DB::table('email_verifications')
                    ->where('email', $emailAddress)
                    ->update([
                        'otp' => Hash::make($randomOtp),
                        'expires_at' => now()->addMinutes(5),
                        'attempts' => 0,
                        'verified' => 0,
                        'updated_at' => now()
                    ]);
            }
        }
        return $record;
    }
    public function verify_otp($userOtp,$id):bool{
        $record = DB::table('email_verifications')
        ->where('id', $id)
        ->first();
        if(Hash::check($userOtp, $record->otp)){
            return true;
        }
        else{
            return false;
        }
    }
}