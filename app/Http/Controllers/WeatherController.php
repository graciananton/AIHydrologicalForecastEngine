<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Log;
use App\Services\Formatter\ResponseFormatter;

class WeatherController extends Controller
{
    private array $params;
    private WeatherService $WeatherService;
    public function __construct(WeatherService $WeatherService, Request $request){
        $this->WeatherService = $WeatherService;
        $this->params = $this->WeatherService->normalizeParams($request->query());
    }
    public function process(){
        $result = ResponseFormatter::process($this->params['f'],$this->WeatherService->filter($this->params));
        return $result;
    }
    public function sync(){
        if($this->WeatherService->sync()){
            return redirect()->back()->with(
                'success',
                'Weather sync completed successfully'
            );
        }
        return redirect()->back()->with(
            'error',
            'Weather sync completed unsuccessfully'
        );
    }
}