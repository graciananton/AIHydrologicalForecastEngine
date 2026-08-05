<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserStationService
{
    public function validStationId($stationId){
        $response = Http::get("https://gracian.ca/laravel/public/api/stations");
        $stations = $response->json();
        foreach($stations as $station){
            if($stationId == $station->stationId){
                return true;
            }
        }
        return false;
    }
    public function getUser(string $email):?User{
        $query = User::query();
        $query->where('email', $email);
        
        $user = $query->first();

        return ($user) ? $user : null;
    }

}
