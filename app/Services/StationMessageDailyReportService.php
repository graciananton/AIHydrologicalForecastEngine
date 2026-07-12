<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\StationMessageMail;
use App\Models\ApplicationErrors;
use Illuminate\Support\Facades\Http;

class StationMessageDailyReportService{
    public function sendStationMessageDailyReport(){
        try{
            $users = User::get()->toArray();

            $usersList = [];
            for($i=0;$i<count($users);$i++){
                $user = $users[$i];
                $stationId = $user['stationId'];
                $url = "http://gracian.ca/laravel/public/api/stationMessage?stationId=".$stationId."&order=desc&limit=1";
                $stationMessage = Http::get($url);
                $stationMessage = json_decode($stationMessage, true)[0];
                $message = $stationMessage['message'];

                $usersList[] = $user['name'];
                
                Mail::to($user['email'])->send(new StationMessageMail($message));
            }

           // $errors = ApplicationErrors::where('created_at', '>', Carbon::now()->subDay())->get()->toArray();
           // Mail::to("GracianAnton@cmail.carleton.ca")->send(new StationMessageMail($errors));
            return response()->json("DailyReport sent for ". $usersList.join(", "));
        }
        catch(\Throwable $e){
            throw $e;
        }
    }
}