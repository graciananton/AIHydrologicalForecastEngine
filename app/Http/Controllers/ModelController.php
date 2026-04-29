<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AuthController extends Controller{
    public function train_model(){
        Http::post('http://127.0.0.1:8000/hello');
    }
    public function test_model(){

    }
    public function fine_tuning(){

    }
}