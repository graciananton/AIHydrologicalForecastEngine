<?php
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Log::channel("weather")->info("Console readings");

Schedule::command('weather:scheduler')->hourly()->withoutOverlapping();
Schedule::command('reading:scheduler')->hourly()->withoutOverlapping(expiresAt: 30);
Schedule::command('status:scheduler')->monthly()->withoutOverlapping();


/* Running Jobs */
/*
Schedule::command('plotTrain:scheduler')
    ->dailyAt('00:00')
    ->withoutOverlapping();

Schedule::command('plotTest:scheduler')
    ->dailyAt('00:30')
    ->withoutOverlapping();
*/

Schedule::command('train:scheduler')
    ->weekly()->at('01:30')
    ->withoutOverlapping();

Schedule::command('test:scheduler')
    ->weekly()->at('02:00')
    ->withoutOverlapping();

Schedule::command('future:scheduler')
    ->hourly()
    ->withoutOverlapping();


    
Schedule::command('plotFuture:scheduler')
    ->hourly()
    ->withoutOverlapping();
 
Schedule::command('dailyReport:scheduler')
    ->dailyAt('03:00')
    ->withoutOverlapping();

Schedule::command('stationMessage:scheduler')
    ->dailyAt('03:30')
    ->withoutOverlapping();

Schedule::command('stationMessageDailyReport:scheduler')
    ->dailyAt('04:00')
    ->withoutOverlapping();

