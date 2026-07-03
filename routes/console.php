<?php
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Log::channel("weather")->info("Console readings");

Schedule::command('weather:scheduler')->hourly()->withoutOverlapping();
Schedule::command('reading:scheduler')->everyMinute()->withoutOverlapping();
Schedule::command('status:scheduler')->monthly()->withoutOverlapping();


/* Running Jobs */
Schedule::command('plotTrain:scheduler')
    ->dailyAt('00:00')
    ->withoutOverlapping();

Schedule::command('plotTest:scheduler')
    ->dailyAt('00:30')
    ->withoutOverlapping();

Schedule::command('plotFuture:scheduler')
    ->hourly()
    ->withoutOverlapping();

Schedule::command('train:scheduler')
    ->dailyAt('01:30')
    ->withoutOverlapping();

Schedule::command('test:scheduler')
    ->dailyAt('02:00')
    ->withoutOverlapping();

Schedule::command('future:scheduler')
    ->hourly()
    ->withoutOverlapping();

Schedule::command('dailyReport:scheduler')
    ->dailyAt('03:00')
    ->withoutOverlapping();


