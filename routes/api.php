<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ReadingsController;
use App\Http\Controllers\StationsController;
use App\Http\Controllers\WeatherController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/readings',[ReadingsController::class,'process']);

    Route::get('/stations',[StationsController::class,'process']);

    Route::get('/weather',[WeatherController::class,'process']);
});

