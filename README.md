# GPX PHP

GPX library for PHP

## What is this?

GPX (GPS Exchange Format) is a de facto standard file format for sharing GPS tracks in the travel/adventure/overland circles. The library contains a GPX reader and writer allowing you to easily work with GPX files in PHP applications.

![gpxphp.jpg](https://github.com/loskoderos/gpx-php/raw/master/gpxphp.jpg)

What is GPX used for? In general its a common format to share routes and tracks recorded by GPS devices. While travelling you can keep recording your current location with your GPS device and then export that track in the GPX format to other software or share it with others.

More information about the GPX format:
https://en.wikipedia.org/wiki/GPS_Exchange_Format
http://www.topografix.com/GPX/1/1

## Installation
GPX-PHP is still under development, however if you want to try it out you can 
easily install it with Composer:
~~~
composer config minimum-stability dev
composer require loskoderos/gpx-php:dev-master
~~~

## Reading GPX files
Sample code to read contents of the GPX file and list point coordinates.
~~~
<?php

use LosKoderos\GPX\GPXReader;

require '../vendor/autoload.php';

$reader = new GPXReader();
$gpx = $reader->readFromFile('garmin.gpx');

foreach ($gpx->routes as $route) {
    echo sprintf("[%0.8f, %0.8f] %s\n",
        (float) $route->points[0]->latitude,
        (float) $route->points[0]->longitude,
        $route->name);
}
~~~

## Writing GPX files
The library contain model representing each of the entities found in the GPX specification. You can create a GPX by adding elements one by one.
~~~
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
~~~

Other option to create a GPX is simply by passing GPX as array to the writer.
~~~
<?php

use LosKoderos\GPX\GPXWriter;
use LosKoderos\GPX\Model\GPX;

require '../vendor/autoload.php';

const DATA = [
    'version' => '1.1',
    'creator' => 'gpx-php',
    'metadata' => [
        'name' => 'Sample track',
        'author' => [
            'name' => 'Johnnie Walker',
            'email' => ['id' => 'johnie', 'domain' => 'walker.tld']
        ]
    ],
    'tracks' => [
        [
            'name' => 'Track 1',
            'segments' => [
                [
                    'points' => [
                      [
                          'latitude' => 50.0583,
                          'longitude' => 19.8006,
                          'time' => new \DateTime("+1 minutes")
                      ],
                      [
                          'latitude' => 50.0584,
                          'longitude' => 19.8007,
                          'time' => new \DateTime("+2 minutes")
                      ],
                      [
                          'latitude' => 50.0588,
                          'longitude' => 19.8009,
                          'time' => new \DateTime("+3 minutes")
                      ],
                    ]
                ]
            ]
        ]
    ]  
];

$gpx = new GPX(DATA);
$writer = new GPXWriter();
echo $writer->writeToString($gpx);
~~~

## Contributing
Contributions are welcome, please submit a pull request.

## License
MIT
