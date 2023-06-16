<?php

use LosKoderos\GPX\GPXReader;
use LosKoderos\GPX\Utils\Haversine;

require '../vendor/autoload.php';

$reader = new GPXReader();
$gpx = $reader->readFromFile('mapout.gpx');
$distance = Haversine::estimateTotalLength($gpx);
echo sprintf("Estimated total length: %0.2f km\n", $distance);
