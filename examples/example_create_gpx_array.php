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
