<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ReadingsController;
use App\Http\Controllers\StationsController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\LogController;

Route::middleware(['web', 'auth'])->group(function () {
    Log::channel("laravel")->info("Running API");
    Route::get('/readings',[ReadingsController::class,'process']);

    Route::get('/stations',[StationsController::class,'process']);

    Route::get('/weather',[WeatherController::class,'process']);

    Route::get('/logs',[LogController::class,'process']);
});

