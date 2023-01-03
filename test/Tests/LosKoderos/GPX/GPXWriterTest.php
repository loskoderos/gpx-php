<?php

namespace Tests\LosKoderos\GPX;

use LosKoderos\GPX\GPXReader;
use LosKoderos\GPX\GPXWriter;
use LosKoderos\GPX\Model\GPX;
use PHPUnit\Framework\TestCase;

const GPX_DATA = [
    'version' => '1.1',
    'creator' => 'Test',
    'metadata' => [
        'name' => 'Test name',
        'description' => 'Test description',
        'author' => [
            'name' => 'Test author',
            'email' => ['id' => 'foo', 'domain' => 'bar.tld'],
            'link' => [
                'href' => 'https://test.tld',
                'text' => 'Test author link text',
                'type' => 'Test author link type'
            ]
        ],
        'copyright' => [
            'author' => 'Test copyright author',
            'year' => 2022,
            'license' => 'https://test.tld/license.txt'
        ],
        'links' => [
            [
                'href' => 'https://link1.tld',
                'text' => 'Test link1 text',
                'type' => 'Test link1 type'
            ],
            [
                'href' => 'https://link2.tld',
                'text' => 'Test link2 text',
                'type' => 'Test link2 type'
            ]
        ],
        'time' => '2020-04-20T20:47:58+00:00',
        'keywords' => 'test1, test2, test3',
        'bounds' => [
            'maxLatitude' => 50.7246,
            'maxLongitude' => 21.7474,
            'minLatitude' => 50.0499,
            'minLongitude' => 19.8516
        ],
        'extensions' => [
            [
                'name' => 'foo',
                'attributes' => ['x' => 123, 'y' => 456],
                'children' => [],
                'content' => null
            ],
            [
              'name' => 'bar',
              'attributes' => ['x' => 321, 'y' => 654],
              'content' => 'test'
          ]
      ]
    ],
    'waypoints' => [
        [
            'latitude' => 1.23,
            'longitude' => 4.56,
            'elevation' => 7.89,
            'time' => '2020-04-20T12:34:57+00:00',
            'magneticVariation' => 1.23,
            'geoidHeight' => 321,
            'name' => 'Test waypoint 1',
            'comment' => 'Comment for waypoint 1',
            'description' => 'Description for waypoint 1',
            'source' => 'Source for waypoint 1',
            'links' => [
                [
                    'href' => 'https://link1.tld/waypoint1',
                    'text' => 'Test link1 text for waypoint 1',
                    'type' => 'Test link1 type for waypoint 1'
                ],
                [
                    'href' => 'https://link2.tld/waypoint1',
                    'text' => 'Test link2 text for waypoint 1',
                    'type' => 'Test link2 type for waypoint 1'
                ]
            ],
            'symbol' => 'Waypoint 1',
            'type' => 'Type 1',
            'fix' => 'none',
            'satellites' => 9,
            'horizontalDilution' => 1.23,
            'verticalDilution' => 4.56,
            'positionDilution' => 7.89,
            'ageOfDgpsData' => 321,
            'dgpsId' => 123
        ],
        ['latitude' => 3.33, 'longitude' => 4.44],
        ['latitude' => 5.55, 'longitude' => 6.66],
        ['latitude' => 7.77, 'longitude' => 8.88],
    ],
    'routes' => [
        [
            'name' => 'Test route 1',
            'comment' => 'Comment for route 1',
            'description' => 'Description for route 1',
            'links' => [
                [
                    'href' => 'https://link1.tld/route1',
                    'text' => 'Test link1 text for route 1',
                    'type' => 'Test link1 type for route 1'
                ],
                [
                    'href' => 'https://link2.tld/route1',
                    'text' => 'Test link2 text for route 1',
                    'type' => 'Test link2 type for route 1'
                ]
            ],
            'number' => 123,
            'type' => 'type 1',
            'points' => [
                [
                    'name' => 'Test route 1 waypoint 1',
                    'latitude' => 3.21,
                    'longitude' => 6.54
                ],
                [
                    'name' => 'Test route 1 waypoint 2',
                    'latitude' => 7.89,
                    'longitude' => 1.23
                ],
                [
                    'name' => 'Test route 1 waypoint 3',
                    'latitude' => 4.56,
                    'longitude' => 3.21
                ],
            ]
        ],
    ],
    'tracks' => [
        [
            'name' => 'Test track 1',
            'comment' => 'Comment for track 1',
            'description' => 'Description for track 1',
            'source' => 'Source for track 1',
            'links' => [
                [
                    'href' => 'https://link1.tld/track1',
                    'text' => 'Test link1 text for track 1',
                    'type' => 'Test link1 type for track 1'
                ],
                [
                    'href' => 'https://link2.tld/track1',
                    'text' => 'Test link2 text for track 1',
                    'type' => 'Test link2 type for track 1'
                ]
            ],
            'number' => 123,
            'type' => 'test type',
            'segments' => [
                [
                    'points' => [
                        [
                            'latitude' => 50.0583,
                            'longitude' => 19.8006,
                            'elevation' => 231
                        ],
                        [
                          'latitude' => 50.0584,
                          'longitude' => 19.8007,
                          'elevation' => 456
                        ],
                        [
                          'latitude' => 50.0588,
                          'longitude' => 19.8009,
                          'elevation' => 897
                        ]                      
                    ]
                ]
            ]
        ]
    ],
    'extensions' => []
];

class GPXWriterTest extends TestCase
{
    public function testWriter_synthethic()
    {
        $tempFile = tempnam('/tmp', 'gpx-');
        
        $writer = new GPXWriter();
        $writer->write(new GPX(GPX_DATA), $tempFile);


        $reader = new GPXReader();
        $gpx = $reader->read($tempFile);

        $this->assertArraysAreIdentical(GPX_DATA, $gpx->toArray());

        @unlink($tempFile);
    }

    public function testWriter_processSampleGPX()
    {
      $tempFile = tempnam('/tmp', 'gpx-');

      $reader = new GPXReader();
      $writer = new GPXWriter();
        
      $srcGPX = $reader->read('test/test.gpx');
      $writer->write($srcGPX, $tempFile);
      $destGPX = $reader->read($tempFile);

      $this->assertArraysAreIdentical($srcGPX->toArray(), $destGPX->toArray());

      @unlink($tempFile);
    }

    protected function assertArraysAreIdentical(array $a, array $b)
    {
        $this->_recursivelyCompareArray($a, $b, 'A', 'B');
        $this->_recursivelyCompareArray($b, $a, 'B', 'A');
    }

    protected function _recursivelyCompareArray(array $a, array $b, string $la, string $lb)
    {
        foreach ($a as $k => $v) {
            if (!empty($v)) {
                // Make sure the other array has the same key.
                $this->assertArrayHasKey($k, $b, sprintf('%s.%s does not exist in %s', $la, $k, $lb));

                if (is_array($v) && is_array($b[$k])) {
                    // Get deeper, recursion.
                    $this->_recursivelyCompareArray($v, $b[$k], $la.'.'.$k, $lb.'.'.$k);
                
                  } else {
                    if (!empty($v) || !empty($b[$k])) {
                        if (is_float($v) && is_float($b[$k])) {
                            // Floating point are nearly equal.
                            $this->assertTrue(abs($v - $b[$k]) < 0.0001);
                        } else {
                            // Make sure values are equal.
                            $this->assertEquals($v, $b[$k], sprintf('%s.%s does not match %s.%s', $la, $k, $lb, $k));
                        }
                    }
                }
            
            } else {
                // Skip empty.
                $this->assertTrue(!isset($b[$k]) || empty($b[$k]), sprintf('%s.%s does not match %s.%s', $la, $k, $lb, $k));
            }
        }
    }
}
