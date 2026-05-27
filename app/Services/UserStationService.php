<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserStationService
{
    public function getUser(string $email):?User{
        $query = User::query();
        $query->where('email', $email);
        
        $user = $query->first();

        return ($user) ? $user : null;
    }
}
