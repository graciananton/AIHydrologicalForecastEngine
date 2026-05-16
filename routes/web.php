<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ReadingsController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//echo request()->path();
Route::get('/',[HomeController::class,'process']);

Route::get('/workflow',[WorkflowController::class,'process']);

Route::get('login', [AuthController::class,'login'])->name('login');

Route::get('/verification_code',[AuthController::class,'verification_code'])->name("verification_code");

Route::post('/login_submit',[AuthController::class,'login_submit']);

Route::get('/dashboard', [DashboardController::class, 'process'])->middleware('auth','admin');

Route::get('/status', [StatusController::class, 'process'])->middleware('auth');

Route::get('/weather_sync',[WeatherController::class,'sync'])->middleware('auth');

Route::get('/readings_sync',[ReadingsController::class,'sync'])->middleware('auth');

#Route::get('/delete_records',[StatusController::class,'deleteRecords'])->middleware('auth');

Route::get('/statuses_sync',[StatusController::class,'sync'])->middleware('auth');

#->middleware('auth')

