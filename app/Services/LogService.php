<?php
namespace App\Services;
use Illuminate\Support\Facades\Log;

class LogService{
    public function getLogs(string $numberOfLogs){
        $lines = file(storage_path("logs/laravel.log"));
    
        $logs = [];
        $index = 0;

        $start = count($lines)-$numberOfLogs;
        if(count($lines)-$numberOfLogs < 0){
            $start = 0;
        }

        for($i=$start;$i<count($lines);$i++){
            $logs[$index] = $lines[$i];
            $index = $index + 1;
        }

        return response()->json(
            $logs
        );
    }
}