<?php

use LosKoderos\GPX\GPXReader;

require '../vendor/autoload.php';

function haversine(float $lat1, float $lon1, float $lat2, float $lon2)
{
    $dlat = ($lat2 - $lat1) * M_PI / 180.0;
    $dlon = ($lon2 - $lon1) * M_PI / 180.0;

    $lat1 = $lat1 * M_PI / 180.0;
    $lat2 = $lat2 * M_PI / 180.0;

    $a = pow(sin($dlat / 2.0), 2) + pow(sin($dlon / 2.0), 2) * cos($lat1) * cos($lat2);
    return 6471.0 * 2.0 * asin(sqrt($a));
}

$reader = new GPXReader();
$gpx = $reader->readFromFile('mapout.gpx');

$coords = [];
foreach ($gpx->tracks as $track) {
    foreach ($track->segments as $segment) {
        foreach ($segment->points as $point) {
            array_push($coords, [(float) $point->latitude, (float) $point->longitude]);
        }
    }
}

$distance = 0.0;
for ($i = 0; $i < count($coords)-1; $i++) {
    $a = $coords[$i];
    $b = $coords[$i+1];
    $distance += haversine($a[0], $a[1], $b[0], $b[1]);
}

echo sprintf("Estimated track distance: %0.2f km\n", $distance);
