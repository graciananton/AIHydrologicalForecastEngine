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
use App\Http\Controllers\ModelController;

Route::post('/request_otp',[AuthController::class,'request_otp']);

Route::post('/request_verify_otp',[AuthController::class,'request_verify_otp']);

# get the RMSE score of the test set

Route::get('/testAll',[ModelController::class,'testAll']);

Route::get('/testSingle',[ModelController::class,'testSingle']);




# get the future predictions as json
Route::get('/futureSetSingle',[ModelController::class,'futureSetSingle']);
Route::get('/futureSetAll',[ModelController::class,'futureSetAll']);



# train the model
Route::get('/trainSingle', [ModelController::class,'trainSingle']);

Route::get('/trainAll', [ModelController::class,'trainAll']);


# plot the training data (top 80% of past data)
Route::get('/plotTrainSingle',[ModelController::class,'plotTrainSingle']);

Route::get('/plotTrainAll', [ModelController::class,'plotTrainAll']);



# plot the test data (bottom 20% of past data)
Route::get("/plotTestSingle",[ModelController::class,'plotTestSingle']);

Route::get("/plotTestAll",[ModelController::class,'plotTestAll']);

# plot the future predictions
Route::get("/plotFutureSingle",[ModelController::class,'plotFutureSingle']);

Route::get("/plotFutureAll",[ModelController::class,'plotFutureAll']);


Route::get('/fine_tuning',[ModelController::class, 'fine_tune_model']);


#Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/readings',[ReadingsController::class,'process']);

    Route::get('/stations',[StationsController::class,'process']);

    Route::get('/weather',[WeatherController::class,'process']);

    Route::get('/logs',[LogController::class,'process']);
#});

