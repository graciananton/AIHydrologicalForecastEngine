<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\StatusService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;   
class StatusController extends Controller
{
    private array $params;
    private StatusService $StatusService;
    public function __construct(StatusService $StatusService){
        $this->StatusService = $StatusService;
    }
    public function process(){
       $recentDateTimes = $this->StatusService->getDateTimes();
       $recentDateTimes['status']['loggedIn'] = true;
       return view("status.status", [
            "readings" => $recentDateTimes['readings'],
            "weather"  => $recentDateTimes['weather'],
            "status"   => $recentDateTimes['status']
        ]);
    }
    public function deleteRecords(){
        if($this->StatusService->deleteRecords() & $this->StatusService->updateStatus("deleted records beyond one month")){
            return redirect()->back()->with(
                'success',
                'Status not updated'
            );
        }
        else{
            return redirect()->back()->with(
                'error',
                'Status updated'
            );
        }  
    }
}