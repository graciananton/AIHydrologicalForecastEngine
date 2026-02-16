<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkflowController extends Controller
{
    private array $params;
    public function __construct(){
    }
    public function process(){
        return view('workflow');
    }
}