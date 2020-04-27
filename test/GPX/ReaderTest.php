<?php

namespace Test\GPX;

use GPX\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    public function testReader()
    {
        $gpx = Reader::read('samples/track1.gpx');
        var_dump($gpx);
    }
}
