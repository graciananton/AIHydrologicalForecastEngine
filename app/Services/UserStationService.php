<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class TrainService
{
    public function getUser(string $emailAddress){
        $query = User::query();
        $query->where('emailAddress', $emailAddress);
        
        $result = $query->get()->toArray();

        if($result){
            return $result;
        }
        return null;
    }
}
