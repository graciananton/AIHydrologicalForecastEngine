<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\LevelService;
use App\Services\Formatter\ResponseFormatter;

class HomeController extends Controller
{
    private array $params;
    private HomeService $HomeService;
    private $request;
    public function __construct(HomeService $HomeService, Request $request){
        $this->HomeService = $HomeService;
        $this->request = $request;
    }
    public function process(){
       
    }
}