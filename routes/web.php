<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ReadingsController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//echo request()->path();
Route::get('/',[HomeController::class,'process']);

Route::get('/workflow',[WorkflowController::class,'process']);

Route::get('/login',[AuthController::class,'login'])->name('login');

Route::post('/login_submit',[AuthController::class,'login_submit']);

#Route::post('/login_submit1', function () {
#    dd('1. POST route reached');
#});

Route::get('/status', [StatusController::class, 'process'])->middleware('auth');

Route::post('/send_otp',[AuthController::class,'send_otp']);

Route::post('/verify_otp',[AuthController::class,'verify_otp']);


Route::get('/weather_sync',[WeatherController::class,'sync'])->middleware('auth');

Route::get('/readings_sync',[ReadingsController::class,'sync'])->middleware('auth');

Route::get('/delete_records',[StatusController::class,'deleteRecords'])->middleware('auth');

#->middleware('auth')

