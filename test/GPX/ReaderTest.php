<?php

namespace Test\GPX;

use GPX\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    public function testReader()
    {
        $reader = new Reader();
        $gpx = $reader->read('samples/track1.gpx');
        var_dump($gpx);
    }
}
