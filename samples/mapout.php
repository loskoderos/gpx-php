<?php

use GPX\GPXReader;

require '../vendor/autoload.php';

$reader = new GPXReader();
$gpx = $reader->read('mapout.gpx');

foreach ($gpx->tracks as $track) {
    echo $track->name . "\n";
    foreach ($track->segments as $segment) {
        foreach ($segment->points as $point) {
            echo $point->latitude . ' ' . $point->longitude . ' ' . $point->elevation . "\n";
        }
    }
}
