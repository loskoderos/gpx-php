<?php

namespace Test\GPX;

use GPX\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    public function testReader()
    {
        $reader = new Reader();
        $gpx = $reader->read('test/test1.gpx');

        // Test GPX
        $this->assertEquals($gpx->version, '1.1');
        $this->assertEquals($gpx->creator, 'Test');

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

        var_dump($gpx);
    }
}
