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
use App\Http\Controllers\StationMessagesController;
use App\Http\Controllers\RegisterController;
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

Route::get('/verificationMessage', [AuthController::class, 'verificationMessage']);

Route::get('/dashboard', [DashboardController::class, 'process'])->middleware('auth','admin');

#Route::get('/userStation', [UserStationController::class,'process'])->middleware('auth');
#Route::get('/userStation', [UserStationController::class,'process']);
Route::get('/userStation/{id?}', [UserStationController::class,'process'])->whereAlphaNumeric('id');


Route::get('/stationMessages', [StationMessagesController::class,'process'])->middleware('auth');

Route::get('/status', [StatusController::class, 'process'])->middleware('auth');

Route::get('/weather_sync',[WeatherController::class,'sync'])->middleware('auth');

Route::get('/readings_sync',[ReadingsController::class,'sync'])->middleware('auth');

Route::get('/register', function(){
    return view('auth.register');
});

Route::get('/termsOfUse', function(){
    return view('legal.termsOfUse');
});
Route::get('/privacyPolicy', function(){
    return view('legal.privacyPolicy');
});


Route::post('/registerSubmit', [RegisterController::class,'process']);

#Route::get('/delete_records',[StatusController::class,'deleteRecords'])->middleware('auth');

Route::get('/statuses_sync',[StatusController::class,'sync'])->middleware('auth');

#->middleware('auth')
/*
Route::match(['get'], ['/home','/'], function(){
    return view('home', ['request' => 'home']);

});
*/
Route::get('/home', function(){
    return view('home', ['request' => 'home']);
});
Route::get('/', function(){
    return view('home', ['request' => 'home']);
});


Route::get('/privacyPolicy', function(){
    return view('home', ['request' => 'privacyPolicy']);
});

Route::get('/termsOfUse', function(){
    return view('home', ['request' => 'termsOfUse']);
});

Route::get('/methodology', function(){
    return view('home', ['request' => 'methodology']);
});
