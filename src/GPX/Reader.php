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
                switch ($reader->name) {
                    case 'gpx':
                        $gpx
                            ->setVersion($reader->getAttribute('version'))
                            ->setCreator($reader->getAttribute('creator'));
                        break;

                    case 'metadata':
                        var_dump($reader->readInnerXml());
                        break;
                }

                var_dump($reader->name);
            }
        }

        $reader->close();

        return $gpx;
    }
}
