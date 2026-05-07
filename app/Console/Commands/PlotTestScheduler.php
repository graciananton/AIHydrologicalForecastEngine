<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PlotTestScheduler extends Command
{
    protected $signature = 'plotTest:scheduler';

    public function handle()
    {        
        $response = Http::get(
            'http://gracian.ca/laravel/public/api/plotTestAll',
        );
    }
}