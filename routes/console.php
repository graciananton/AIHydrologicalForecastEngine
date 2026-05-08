<?php
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Log::channel("weather")->info("Console readings");

Schedule::command('weather:scheduler')->hourly()->withoutOverlapping();
Schedule::command('reading:scheduler')->everyMinute()->withoutOverlapping();
Schedule::command('status:scheduler')->monthly()->withoutOverlapping();


/* Running Jobs */
Schedule::command('plotTrain:scheduler')->daily()->withoutOverlapping();
Schedule::command('plotTest:scheduler')->daily()->withoutOverlapping();
Schedule::command('plotFuture:scheduler')->daily()->withoutOverlapping();

Schedule::command('train:scheduler')->daily()->withoutOverlapping();
Schedule::command('test:scheduler')->daily()->withoutOverlapping();


