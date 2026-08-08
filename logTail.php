<?php
$file = "http://gracian.ca/forecasting//storage/logs/weather.log";

$lines = file($file);
$total = count($lines);

for ($i = $total - 100; $i < $total; $i++) {
    if ($i >= 0) {
        echo htmlspecialchars($lines[$i]) . "<br>";
    }
}