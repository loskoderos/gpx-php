<?php

namespace GPX;

use GPX\Models\Bounds;
use GPX\Models\Link;
use GPX\Models\Metadata;
use GPX\Models\GPX;
use GPX\Models\Person;
use XMLReader;

class Reader
{
    public function read($filename): GPX
    {
        $gpx = new GPX();

        $xml = new XMLReader();
        $xml->open($filename);

        while ($xml->read()) {

            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'gpx':
                        $gpx->version = $xml->getAttribute('version');
                        $gpx->creator = $xml->getAttribute('creator');
                        break;

                    case 'metadata':
                        $gpx->metadata = $this->parseMetadata($xml);
                        break;
                }
            }
        }

        $xml->close();

        return $gpx;
    }

    protected function parseMetadata(XMLReader $xml)
    {
        $metadata = new Metadata();

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'metadata') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'name':
                        $xml->read();
                        $metadata->name = $xml->value;
                        break;

                    case 'desc':
                        $xml->read();
                        $metadata->description = $xml->value;
                        break;

                    case 'author':
                        $metadata->author = $this->parseAuthor($xml);
                        break;

                    case 'copyright':
                        break;

                    case 'link':
                        array_push($metadata->links, $this->parseLink($xml));
                        break;

                    case 'time':
                        $xml->read();
                        $metadata->time = new \DateTime($xml->value);
                        break;

                    case 'keywords':
                        $xml->read();
                        $metadata->keywords = $xml->value;
                        break;

                    case 'bounds':
                        $metadata->bounds = new Bounds();
                        $metadata->bounds->minLatitude = $xml->getAttribute('minlat');
                        $metadata->bounds->minLongitude = $xml->getAttribute('minlon');
                        $metadata->bounds->maxLatitude = $xml->getAttribute('maxlat');
                        $metadata->bounds->maxLongitude = $xml->getAttribute('maxlon');
                        break;

                    case 'extensions':
                        break;
                }
            }
        }

        return $metadata;
    }

    protected function parseLink(XMLReader $xml)
    {
        $link = new Link();
        $link->href = (string) $xml->getAttribute('href');

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'link') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'text':
                        $xml->read();
                        $link->text = $xml->value;
                        break;

                    case 'type':
                        $xml->read();
                        $link->type = $xml->value;
                        break;
                }
            }
        }

        return $link;
    }

    protected function parseAuthor(XMLReader $xml)
    {
        $author = new Person();

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'author') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'name':
                        $xml->read();
                        $author->name = $xml->value;
                        break;

                    case 'email':
                        break;

                    case 'link':
                        $author->link = $this->parseLink($xml);
                        break;
                }
            }
        }

        return $author;
    }
}
