<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StatusService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;   
class StatusController extends Controller
{
    private array $params = [];
    private StatusService $StatusService;
    public function __construct(StatusService $StatusService, Request $request){
        $this->StatusService = $StatusService;
        $this->params = $this->StatusService->normalizeParams($request->query());
    }

    public function process(){
        $result = response()->json($this->StatusService->filter($this->params));
        return $result;
    }

    public function deleteRecords(){
        if($this->StatusService->deleteRecords() && $this->StatusService->updateStatus("deleted records beyond one month")){
            return redirect()->back()->with(
                'success',
                'Status updated'
            );
        }
        else{
            return redirect()->back()->with(
                'error',
                'Status not updated'
            );
        }  
    }
}