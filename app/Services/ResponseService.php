<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ResponseService
{
    public function sync($params){

        $response = Http::timeout(1200)->post("http://127.0.0.1:8000/generate_response", [
            "messages" => json_encode($params['messages'])
        ]);


        if (!$response->successful()) { // this is for 200-299 (success)
            throw new \RuntimeException(
                "generate_response FastAPI request failed for "
            );
        } 
        
        $data = $response->json();

        if (!is_array($data)) {
            throw new \UnexpectedValueException(
                "generate_response response is not valid output for"
            );
        }

        return $data;
    }
}