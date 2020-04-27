<?php

namespace GPX;

use GPX\Types\GPX;

class Reader
{
    public static function read($filename): GPX
    {
        $gpx = new GPX();

        $reader = new \XMLReader();
        $reader->open($filename);

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT) {
                if ($reader->name == 'gpx') {
                    $gpx->setVersion($reader->getAttribute('version'));
                }
            }
        }

        return $gpx;
    }
}
