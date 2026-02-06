<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StationService;
use App\Services\Formatter\ResponseFormatter;
use App\Services\ReadingService;

class StationsController extends Controller{
    private array $params = [];
    private StationService $StationService;
    public function __construct(StationService $StationService, Request $request){
        $this->StationService = $StationService;
        $this->params = $this->StationService->normalizeParams($request->query());
    }
    public function process(){
        $result = ResponseFormatter::process($this->params['f'],$this->StationService->filter($this->params));
        return $result;
    }
}
