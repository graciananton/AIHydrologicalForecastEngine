
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ReadingsController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//echo request()->path();
Route::get('/',[WorkflowController::class,'process']);

Route::get('/login',[AuthController::class,'login'])->name('login');

Route::post('/login_submit',[AuthController::class,'login_submit']);

#Route::post('/login_submit1', function () {
#    dd('1. POST route reached');
#});

Route::get('/status', [StatusController::class, 'process'])->middleware('auth');

Route::get('/signup',[AuthController::class,'signup'])->name('register');

Route::post('/signup_submit',[AuthController::class,'signup_submit']);

Route::get('/weather_sync',[WeatherController::class,'sync'])->middleware('auth');

Route::get('/readings_sync',[ReadingsController::class,'sync'])->middleware('auth');

Route::get('/delete_records',[StatusController::class,'deleteRecords'])->middleware('auth');

#->middleware('auth')

