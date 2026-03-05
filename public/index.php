<?php
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */

$app = require_once __DIR__.'/../bootstrap/app.php';
//dd(env('TEST_VAR'));
//dd(app()->environment());

$request = Request::capture();
/*
echo "<pre>";
var_dump([
    'method' => $request->method(),
    'uri' => $request->getRequestUri(),
    'full_url' => $request->fullUrl(),
    'path' => $request->path(),
    'input' => $request->all(),
    'cookies' => $request->cookies->all(),
    'headers' => $request->headers->all(),
]);
echo "</pre>";*/

$app->handleRequest(Request::capture());