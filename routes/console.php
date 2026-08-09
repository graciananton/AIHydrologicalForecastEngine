<?php
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Log::channel("weather")->info("Console readings");

Schedule::command('weatherProcessing:scheduler')->hourly()->withoutOverlapping();
Schedule::command('readingsProcessing:scheduler')->cron('25 */1 * * *')->withoutOverlapping(expiresAt: 30);

Schedule::command('status:scheduler')->monthly()->withoutOverlapping();

Schedule::command('awake:scheduler')
    ->cron("*/13 * * * *")
    ->withoutOverlapping();

    
Schedule::command('userMessageReport:scheduler')
    ->dailyAt('2:57')
    ->withoutOverlapping();

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
    ->weekly()->at('02:30')
    ->withoutOverlapping();

/* These are the main ones */
// this is every 4 hrs
Schedule::command('future:scheduler')
    ->cron('0 */4 * * *')
    ->withoutOverlapping();

// this is every 12hrs
Schedule::command('plotFuture:scheduler')
    ->cron('0 */12 * * *')
    ->withoutOverlapping();
 
Schedule::command('dailyReport:scheduler')
    ->dailyAt('03:00')
    ->withoutOverlapping();

Schedule::command('stationMessage:scheduler')
    ->dailyAt('03:30')
    ->withoutOverlapping();
   
/*
Schedule::command('stationMessageDailyReport:scheduler')
    ->dailyAt('3:53')
    ->withoutOverlapping();

*/

