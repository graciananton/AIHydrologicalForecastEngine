<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ReadingsController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserStationController;
use App\Services\OtpMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//echo request()->path();
Route::get('/',[HomeController::class,'process']);

Route::get('/workflow',[WorkflowController::class,'process']);

Route::get('login', [AuthController::class,'login'])->name('login');

Route::post('/loginSubmit',[AuthController::class,'loginSubmit']);

Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signupSubmit', [AuthController::class, 'signupSubmit']);


Route::get('/verificationCode', [AuthController::class,'verificationCode']);

Route::post('/verificationCodeSubmit', [AuthController::class,'verificationCodeSubmit']);

Route::get('/dashboard', [DashboardController::class, 'process']);

#Route::get('/dashboard', [DashboardController::class, 'process'])->middleware('auth','admin');

Route::get('/userStation', [UserStationController::class,'process'])->middleware('auth');

Route::get('/status', [StatusController::class, 'process'])->middleware('auth');

Route::get('/weather_sync',[WeatherController::class,'sync'])->middleware('auth');

Route::get('/readings_sync',[ReadingsController::class,'sync'])->middleware('auth');

#Route::get('/delete_records',[StatusController::class,'deleteRecords'])->middleware('auth');

Route::get('/statuses_sync',[StatusController::class,'sync'])->middleware('auth');

#->middleware('auth')

