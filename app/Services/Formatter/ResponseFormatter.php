<?php
namespace App\Services\Formatter;
use Illuminate\Support\Facades\Log;

final class ResponseFormatter{
    public static function process(string $formatType,array $results):string{
        if($formatType == "html"){
            
        }
        else if($formatType == "xml"){
            return response()
                ->view('xml', compact('results'), 200)
                ->header('Content-Type', 'application/xml');
        }
        else{
            return response()->json($results);
        }
    }
}