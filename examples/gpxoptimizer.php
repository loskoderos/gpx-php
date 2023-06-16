<?php

use LosKoderos\GPX\Model\GPX;
use LosKoderos\GPX\Model\Track;
use LosKoderos\GPX\Model\TrackSegment;
use LosKoderos\GPX\GPXReader;
use LosKoderos\GPX\GPXWriter;
use LosKoderos\GPX\Utils\Haversine;

require '../vendor/autoload.php';

if (!isset($argv[1]) || !isset($argv[2])) {
    echo "Simplify GPX by turning routes into tracks.\n";
    echo "Usage: php gpxoptimizer.php <input.gpx> <output.gpx>\n";
    exit(-1);
}

$reader = new GPXReader();

$input = $reader->readFromFile($argv[1]);
$output = new GPX();

foreach ($input->waypoints as $waypoint) {
    echo sprintf("Waypoint [%0.8f, %0.8f] %s\n",
        (float) $waypoint->latitude,
        (float) $waypoint->longitude,
        $waypoint->name);
    $output->waypoints->add($waypoint);
}

foreach ($input->routes as $route) {
    echo sprintf("Route [%0.8f, %0.8f] %s\n",
        (float) $route->points[0]->latitude,
        (float) $route->points[0]->longitude,
        $route->name);
    $segment = new TrackSegment();
    foreach ($route->points as $point) {
        $segment->points->add($point);
    }
    $track = new Track();
    $track->segments->add($segment);
    $output->tracks->add($track);
}

foreach ($input->tracks as $track) {
    echo sprintf("Track [%0.8f, %0.8f] %s\n",
        (float) $track->points[0]->latitude,
        (float) $track->points[0]->longitude,
        $track->name);
    $output->tracks->add($track);
}

$writer = new GPXWriter();
$writer->writeToFile($output, $argv[2]);

echo sprintf("Estimated total length: %0.2f km\n", Haversine::estimateTotalLength($output));
