<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void{
            $schedule->command('weather:scheduler')
                ->everyMinute()
                ->withoutOverlapping();

            $schedule->command('reading:scheduler')
                ->everyMinute()
                ->withoutOverlapping();
            $schedule->command('status:scheduler')
                ->monthly()
                ->withoutOverlapping();
    }

    protected function commands(): void{
            $this->load(__DIR__.'/Commands');

            require base_path('routes/console.php');
    }
}
