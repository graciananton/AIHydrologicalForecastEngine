<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OtpMailService{
    public function send_otp(){
        $otp = random_int(100000, 999999);
        try{
            Mail::to($email)->send(new OtpMail($otp));
            return true;
        }
        catch(\Exception $e){
            return false;
        }
        finally {
            Log::channel("weather")->info("OtpMail verification code running");
        }
    }
}