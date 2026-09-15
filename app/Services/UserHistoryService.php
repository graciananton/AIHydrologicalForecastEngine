<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserHistoryService
{   
    private string $email;
    public function __construct(string $email){
        $this->email = $email;
    }
    public function getUser():?User{
        $query = User::query();
        $query->where('email', $this->email);
        
        $user = $query->first();

        return ($user) ? $user : null;
    }

    public function getJobs(){
        $query =  "SELECT * FROM job_statuses WHERE type LIKE '%StationMessageDailyReportJob%' AND created_at > (SELECT created_at FROM users WHERE email = ?)";

        $jobs = DB::select($query, [$this->email]);

        return $jobs;
    }
}
