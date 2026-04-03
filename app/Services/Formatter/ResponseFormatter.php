<?php
namespace App\Services\Formatter;
use Illuminate\Support\Facades\Log;

final class ResponseFormatter{
    public static function process(string $formatType,array $results):string{
        if($formatType == "html"){
            
        }
        else if($formatType == "xml"){
            $response = view('xml',compact('results'));
        }
        else{
            $response = json_encode($results);
        }
        return $response;
    }
}