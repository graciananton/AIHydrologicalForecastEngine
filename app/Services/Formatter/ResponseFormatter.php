<?php
namespace App\Services\Formatter;

final class ResponseFormatter{
    public static function process(string $format,array $array):string{
        if($format == "html"){
            $response = view('html',compact('array'));
        }
        else if($format == "xml"){
            $response = view('xml',compact('array'));
        }
        else{
            $response = json_encode($array);
        }
        return $response;
    }
}