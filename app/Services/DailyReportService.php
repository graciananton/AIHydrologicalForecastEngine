<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;
use App\Models\ApplicationErrors;

class DailyReportService{
    public function sendDailyReport(){
        try{
            $errors = ApplicationErrors::where('created_at', '>', Carbon::now()->subDay())->get()->toArray();
            Mail::to("GracianAnton@cmail.carleton.ca")->send(new DailyReportMail($errors));
            return response()->json("DailyReport sent for "+Carbon::now()->day());
        }
        catch(\Throwable $e){
            throw $e;
        }
    }
}