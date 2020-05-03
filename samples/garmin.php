<?php

use GPX\GPXReader;

require '../vendor/autoload.php';

$reader = new GPXReader();
$gpx = $reader->read('garmin.gpx');

foreach ($gpx->routes as $route) {
    echo sprintf("[%0.8f, %0.8f] %s\n",
        (float) $route->points[0]->latitude,
        (float) $route->points[0]->longitude,
        $route->name);
}
