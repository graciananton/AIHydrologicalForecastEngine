<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Schedule::command('weather:scheduler')->hourly()->withoutOverlapping();
Schedule::command('reading:scheduler')->everyMinute()->withoutOverlapping();
Schedule::command('status:scheduler')->monthly()->withoutOverlapping();