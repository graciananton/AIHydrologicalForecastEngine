<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ModelService;

class ModelController extends Controller{
    private ModelService $ModelService;
    public function train_model(Request $request){
        return $ModelService->train_model($request->stationId);
    }
    public function test_model(Request $request){
        return $ModelService->test_model($request->stationId);
    }
    public function plot_test(Request $request){
        ($ModelService->plot_test($request->stationId)) ? true: false;
    }
    public function plot_train(Request $request){
        ($ModelService->plot_train($request->stationId)) ? true: false;
    }

    public function future_set(Request $request){
        return $ModelService->future_set($request->stationId);
    }
    public function plot_future(Request $request){
        ($ModelService->plot_future($request->stationId)) ? true: false;
    }

    public function fine_tuning(){
        // add this after
    }
}