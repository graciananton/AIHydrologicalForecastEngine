<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ReadingService;
use App\Services\Formatter\ResponseFormatter;

class ReadingsController extends Controller
{
    private array $params;
    private ReadingService $ReadingService;
    public function __construct(ReadingService $ReadingService, Request $request){
        $this->ReadingService = $ReadingService;
        $this->params = $this->ReadingService->normalizeParams($request->query());
    }
    public function process(){
       return response()->json($this->ReadingService->filter($this->params));
    }
    public function sync(){
        if($this->ReadingService->sync()){
            return redirect()->back()->with(
                'success',
                'Readings sync completed successfully'
            );
        }
        else{
            return redirect()->back()->with(
                'error',
                'Readings sync completed successfully'
            );
        }
    }
}
