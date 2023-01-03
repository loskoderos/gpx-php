<?php

namespace Tests\LosKoderos\GPX;

use LosKoderos\GPX\Model\Route;
use LosKoderos\GPX\Model\Track;
use LosKoderos\GPX\Model\Waypoint;
use LosKoderos\GPX\GPXReader;
use PHPUnit\Framework\TestCase;

class GPXReaderTest extends TestCase
{
    public function testReader()
    {
        $reader = new GPXReader();
        $gpx = $reader->read('test/test.gpx');

        // Test GPX
        $this->assertEquals($gpx->version, '1.1');
        $this->assertEquals($gpx->creator, 'Test');
        $this->assertEquals(count($gpx->waypoints), 5);
        $this->assertEquals(count($gpx->routes), 4);
        $this->assertEquals(count($gpx->tracks), 3);

        // Test Metadata
        $this->assertEquals($gpx->metadata->name, 'Test name');
        $this->assertEquals($gpx->metadata->description, 'Test description');
        $this->assertEquals($gpx->metadata->author->name, 'Test author');
        $this->assertEquals($gpx->metadata->author->email->id, 'foo');
        $this->assertEquals($gpx->metadata->author->email->domain, 'bar.tld');
        $this->assertEquals($gpx->metadata->author->link->href, 'https://test.tld');
        $this->assertEquals($gpx->metadata->author->link->text, 'Test author link text');
        $this->assertEquals($gpx->metadata->author->link->type, 'Test author link type');
        $this->assertEquals($gpx->metadata->copyright->author, 'Test copyright author');
        $this->assertEquals($gpx->metadata->copyright->year, '2020');
        $this->assertEquals($gpx->metadata->copyright->license, 'https://test.tld/license.txt');
        $this->assertEquals(count($gpx->metadata->links), 2);
        $this->assertEquals($gpx->metadata->links[0]->href, 'https://link1.tld');
        $this->assertEquals($gpx->metadata->links[0]->text, 'Test link1 text');
        $this->assertEquals($gpx->metadata->links[0]->type, 'Test link1 type');
        $this->assertEquals($gpx->metadata->links[1]->href, 'https://link2.tld');
        $this->assertEquals($gpx->metadata->links[1]->text, 'Test link2 text');
        $this->assertEquals($gpx->metadata->links[1]->type, 'Test link2 type');
        $this->assertEquals($gpx->metadata->time, new \DateTime('2020-04-20T20:47:58Z'));
        $this->assertEquals($gpx->metadata->keywords, 'test1, test2, test3');
        $this->assertEquals($gpx->metadata->bounds->maxLatitude, '50.724649429321289');
        $this->assertEquals($gpx->metadata->bounds->maxLongitude, '21.7474365234375');
        $this->assertEquals($gpx->metadata->bounds->minLatitude, '50.049934387207031');
        $this->assertEquals($gpx->metadata->bounds->minLongitude, '19.851608276367188');

        // Test Waypoint 1
        /** @var Waypoint $w */
        $w = $gpx->waypoints[0];
        $this->assertEquals($w->latitude, '1.23');
        $this->assertEquals($w->longitude, '4.56');
        $this->assertEquals($w->elevation, '7.89');
        $this->assertEquals($w->time, new \DateTime('2020-04-20T12:34:57Z'));
        $this->assertEquals($w->magneticVariation, '1.23');
        $this->assertEquals($w->geoidHeight, '321');
        $this->assertEquals($w->name, 'Test waypoint 1');
        $this->assertEquals($w->comment, 'Comment for waypoint 1');
        $this->assertEquals($w->description, 'Description for waypoint 1');
        $this->assertEquals($w->source, 'Source for waypoint 1');
        $this->assertEquals(count($w->links), 2);
        $this->assertEquals($w->links[0]->href, 'https://link1.tld/waypoint1');
        $this->assertEquals($w->links[0]->text, 'Test link1 text for waypoint 1');
        $this->assertEquals($w->links[0]->type, 'Test link1 type for waypoint 1');
        $this->assertEquals($w->links[1]->href, 'https://link2.tld/waypoint1');
        $this->assertEquals($w->links[1]->text, 'Test link2 text for waypoint 1');
        $this->assertEquals($w->links[1]->type, 'Test link2 type for waypoint 1');
        $this->assertEquals($w->symbol, 'Waypoint 1');
        $this->assertEquals($w->type, 'Type 1');
        $this->assertEquals($w->fix, 'none');
        $this->assertEquals($w->satellites, '9');
        $this->assertEquals($w->horizontalDilution, '1.23');
        $this->assertEquals($w->verticalDilution, '4.56');
        $this->assertEquals($w->positionDilution, '7.89');
        $this->assertEquals($w->ageOfDgpsData, '321');
        $this->assertEquals($w->dgpsId, '123');

        // Test Route 1
        /** @var Route $r */
        $r = $gpx->routes[1];
        $this->assertEquals($r->name, 'Test route 1');
        $this->assertEquals($r->comment, 'Comment for route 1');
        $this->assertEquals($r->description, 'Description for route 1');
        $this->assertEquals(count($r->links), 2);
        $this->assertEquals($r->links[0]->href, 'https://link1.tld/route1');
        $this->assertEquals($r->links[0]->text, 'Test link1 text for route 1');
        $this->assertEquals($r->links[0]->type, 'Test link1 type for route 1');
        $this->assertEquals($r->links[1]->href, 'https://link2.tld/route1');
        $this->assertEquals($r->links[1]->text, 'Test link2 text for route 1');
        $this->assertEquals($r->links[1]->type, 'Test link2 type for route 1');
        $this->assertEquals($r->number, '123');
        $this->assertEquals($r->type, 'type 1');
        $this->assertEquals(count($r->points), 3);
        $this->assertEquals($r->points[0]->latitude, '3.21');
        $this->assertEquals($r->points[0]->longitude, '6.54');
        $this->assertEquals($r->points[0]->name, 'Test route 1 waypoint 1');
        $this->assertEquals($r->points[1]->latitude, '7.89');
        $this->assertEquals($r->points[1]->longitude, '1.23');
        $this->assertEquals($r->points[1]->name, 'Test route 1 waypoint 2');
        $this->assertEquals($r->points[2]->latitude, '4.56');
        $this->assertEquals($r->points[2]->longitude, '3.21');
        $this->assertEquals($r->points[2]->name, 'Test route 1 waypoint 3');

        // Test Track 1
        /** @var Track $t */
        $t = $gpx->tracks[2];
        $this->assertEquals($t->name, 'Test track 1');
        $this->assertEquals($t->comment, 'Comment for track 1');
        $this->assertEquals($t->description, 'Description for track 1');
        $this->assertEquals(count($t->links), 2);
        $this->assertEquals($t->links[0]->href, 'https://link1.tld/track1');
        $this->assertEquals($t->links[0]->text, 'Test link1 text for track 1');
        $this->assertEquals($t->links[0]->type, 'Test link1 type for track 1');
        $this->assertEquals($t->links[1]->href, 'https://link2.tld/track1');
        $this->assertEquals($t->links[1]->text, 'Test link2 text for track 1');
        $this->assertEquals($t->links[1]->type, 'Test link2 type for track 1');
        $this->assertEquals($t->number, '321');
        $this->assertEquals($t->type, 'test type');
        $this->assertEquals(count($t->segments), 2);
        $this->assertEquals(count($t->segments[0]->points), 3);
        $this->assertEquals($t->segments[0]->points[2]->latitude, '50.05837592981119');
        $this->assertEquals($t->segments[0]->points[2]->longitude, '19.8004615678047');
        $this->assertEquals($t->segments[0]->points[2]->elevation, '231');

        //var_dump($gpx);
    }
}
