<?php

use LosKoderos\GPX\GPXWriter;
use LosKoderos\GPX\Model\GPX;
use LosKoderos\GPX\Model\Track;
use LosKoderos\GPX\Model\TrackSegment;
use LosKoderos\GPX\Model\Waypoint;

require '../vendor/autoload.php';

$gpx = new GPX();
$gpx->creator = 'gpx-php';

$segment = new TrackSegment();

$waypoint = new Waypoint();
$waypoint->latitude = 50.0583;
$waypoint->longitude = 19.8006;
$waypoint->time = new \DateTime("+1 minutes"); 
$segment->points->add($waypoint);

$waypoint = new Waypoint();
$waypoint->latitude = 50.0584;
$waypoint->longitude = 19.8007;
$waypoint->time = new \DateTime("+2 minutes");
$segment->points->add($waypoint);

$waypoint = new Waypoint();
$waypoint->latitude = 50.0588;
$waypoint->longitude = 19.8009;
$waypoint->time = new \DateTime("+3 minutes"); 
$segment->points->add($waypoint);

$track = new Track();
$track->segments->add($segment);

$gpx->tracks->add($track);

$writer = new GPXWriter();
echo $writer->writeToFile($gpx, 'out.gpx');
