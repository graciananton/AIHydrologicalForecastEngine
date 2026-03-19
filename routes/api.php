<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ReadingsController;
use App\Http\Controllers\StationsController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Log;

Log::info("Requesting otp");

//Route::post('/request_otp',[AuthController::class,'request_otp']);

Route::post('/request_verify_otp',[AuthController::class,'request_verify_otp']);

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/readings',[ReadingsController::class,'process']);

    Route::get('/stations',[StationsController::class,'process']);

    Route::get('/weather',[WeatherController::class,'process']);

    Route::get('/logs',[LogController::class,'process']);
});

