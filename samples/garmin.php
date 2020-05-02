<?php

use GPX\GPXReader;

require '../vendor/autoload.php';

$reader = new GPXReader();
$gpx = $reader->read('garmin.gpx');

echo "Routes:\n";
foreach ($gpx->routes as $route) {
    echo $route->name . "\n";
}
