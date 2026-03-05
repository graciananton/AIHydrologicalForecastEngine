<?php
$file = "http://gracian.ca/laravel//storage/logs/weather.log";

$lines = file($file);
$total = count($lines);

for ($i = $total - 30; $i < $total; $i++) {
    if ($i >= 0) {
        echo htmlspecialchars($lines[$i]) . "<br>";
    }
}