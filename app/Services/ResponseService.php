<?php
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResponseService
{
    public function sync($request){

        $response = Http::post("https://fast-api-54so.onrender.com/generate_response", [
            "messages" => $request->messages
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