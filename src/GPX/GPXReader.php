<?php

namespace GPX;

use GPX\Models\Bounds;
use GPX\Models\Copyright;
use GPX\Models\Email;
use GPX\Models\Extension;
use GPX\Models\Link;
use GPX\Models\Metadata;
use GPX\Models\GPX;
use GPX\Models\Person;
use GPX\Models\Route;
use GPX\Models\Track;
use GPX\Models\TrackSegment;
use GPX\Models\Waypoint;
use XMLReader;

class GPXReader
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

                    case 'wpt':
                        array_push($gpx->waypoints, $this->parseWaypoint($xml, 'wpt'));
                        break;

                    case 'rte':
                        array_push($gpx->routes, $this->parseRoute($xml));
                        break;

                    case 'trk':
                        array_push($gpx->tracks, $this->parseTrack($xml));
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

        if ($xml->isEmptyElement) return $metadata;

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
                        $metadata->copyright = $this->parseCopyright($xml);
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
                        $metadata->extensions = $this->parseExtensions($xml);
                        break;
                }
            }
        }

        return $metadata;
    }

    protected function parseLink(XMLReader $xml)
    {
        $link = new Link();
        $link->href = $xml->getAttribute('href');

        if ($xml->isEmptyElement) return $link;

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

        if ($xml->isEmptyElement) return $author;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'author') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'name':
                        $xml->read();
                        $author->name = $xml->value;
                        break;

                    case 'email':
                        $author->email = new Email();
                        $author->email->id = $xml->getAttribute('id');
                        $author->email->domain = $xml->getAttribute('domain');
                        break;

                    case 'link':
                        $author->link = $this->parseLink($xml);
                        break;
                }
            }
        }

        return $author;
    }

    protected function parseCopyright(XMLReader $xml)
    {
        $copyright = new Copyright();
        $copyright->author = $xml->getAttribute('author');

        if ($xml->isEmptyElement) return $copyright;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'copyright') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'year':
                        $xml->read();
                        $copyright->year = $xml->value;
                        break;

                    case 'license':
                        $xml->read();
                        $copyright->license = $xml->value;
                        break;
                }
            }
        }

        return $copyright;
    }

    protected function parseWaypoint(XMLReader $xml, $name)
    {
        $waypoint = new Waypoint();
        $waypoint->latitude = $xml->getAttribute('lat');
        $waypoint->longitude = $xml->getAttribute('lon');

        if ($xml->isEmptyElement) return $waypoint;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == $name) break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'ele':
                        $xml->read();
                        $waypoint->elevation = $xml->value;
                        break;

                    case 'time':
                        $xml->read();
                        $waypoint->time = new \DateTime($xml->value);
                        break;

                    case 'magvar':
                        $xml->read();
                        $waypoint->magneticVariation = $xml->value;
                        break;

                    case 'geoidheight':
                        $xml->read();
                        $waypoint->geoidHeight = $xml->value;
                        break;

                    case 'name':
                        $xml->read();
                        $waypoint->name = $xml->value;
                        break;

                    case 'cmt':
                        $xml->read();
                        $waypoint->comment = $xml->value;
                        break;

                    case 'desc':
                        $xml->read();
                        $waypoint->description = $xml->value;
                        break;

                    case 'src':
                        $xml->read();
                        $waypoint->source = $xml->value;
                        break;

                    case 'link':
                        array_push($waypoint->links, $this->parseLink($xml));
                        break;

                    case 'sym':
                        $xml->read();
                        $waypoint->symbol = $xml->value;
                        break;

                    case 'type':
                        $xml->read();
                        $waypoint->type = $xml->value;
                        break;

                    case 'fix':
                        $xml->read();
                        $waypoint->fix = $xml->value;
                        break;

                    case 'sat':
                        $xml->read();
                        $waypoint->satellites = $xml->value;
                        break;

                    case 'hdop':
                        $xml->read();
                        $waypoint->horizontalDilution = $xml->value;
                        break;

                    case 'vdop':
                        $xml->read();
                        $waypoint->verticalDilution = $xml->value;
                        break;

                    case 'pdop':
                        $xml->read();
                        $waypoint->positionDilution = $xml->value;
                        break;

                    case 'ageofdgpsdata':
                        $xml->read();
                        $waypoint->ageOfDgpsData = $xml->value;
                        break;

                    case 'dgpsid':
                        $xml->read();
                        $waypoint->dgpsId = $xml->value;
                        break;

                    case 'extensions':
                        $waypoint->extensions = $this->parseExtensions($xml);
                        break;
                }
            }
        }

        return $waypoint;
    }

    protected function parseRoute(XMLReader $xml)
    {
        $route = new Route();

        if ($xml->isEmptyElement) return $route;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'rte') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'name':
                        $xml->read();
                        $route->name = $xml->value;
                        break;

                    case 'cmt':
                        $xml->read();
                        $route->comment = $xml->value;
                        break;

                    case 'desc':
                        $xml->read();
                        $route->description = $xml->value;
                        break;

                    case 'src':
                        $xml->read();
                        $route->source = $xml->value;
                        break;

                    case 'link':
                        array_push($route->links, $this->parseLink($xml));
                        break;

                    case 'number':
                        $xml->read();
                        $route->number = $xml->value;
                        break;

                    case 'type':
                        $xml->read();
                        $route->type = $xml->value;
                        break;

                    case 'rtept':
                        array_push($route->points, $this->parseWaypoint($xml, 'rtept'));
                        break;

                    case 'extensions':
                        $route->extensions = $this->parseExtensions($xml);
                        break;
                }
            }
        }

        return $route;
    }

    protected function parseTrack(XMLReader $xml)
    {
        $track = new Track();

        if ($xml->isEmptyElement) return $track;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'trk') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'name':
                        $xml->read();
                        $track->name = $xml->value;
                        break;

                    case 'cmt':
                        $xml->read();
                        $track->comment = $xml->value;
                        break;

                    case 'desc':
                        $xml->read();
                        $track->description = $xml->value;
                        break;

                    case 'src':
                        $xml->read();
                        $track->source = $xml->value;
                        break;

                    case 'link':
                        array_push($track->links, $this->parseLink($xml));
                        break;

                    case 'number':
                        $xml->read();
                        $track->number = $xml->value;
                        break;

                    case 'type':
                        $xml->read();
                        $track->type = $xml->value;
                        break;

                    case 'trkseg':
                        array_push($track->segments, $this->parseTrackSegment($xml));
                        break;

                    case 'extensions':
                        $track->extensions = $this->parseExtensions($xml);
                        break;
                }
            }
        }

        return $track;
    }

    protected function parseTrackSegment(XMLReader $xml)
    {
        $segment = new TrackSegment();

        if ($xml->isEmptyElement) return $segment;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'trkseg') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'trkpt':
                        array_push($segment->points, $this->parseWaypoint($xml, 'trkpt'));
                        break;

                    case 'extensions':
                        array_push($segment->extensions, $this->parseExtensions($xml));
                        break;
                }
            }
        }

        return $segment;
    }

    protected function parseExtensions(XMLReader $xml)
    {
        $extensions = [];

        if ($xml->isEmptyElement) return $extensions;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'extensions') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                array_push($extensions, $this->parseExtension($xml, $xml->name));
            }
        }

        return $extensions;
    }

    protected function parseExtension(XMLReader $xml, $name)
    {
        $extension = new Extension();
        $extension->name = $name;

        if ($xml->hasAttributes) {
            while ($xml->moveToNextAttribute()) {
                $extension->attributes[$xml->name] = $xml->value;
            }
            $xml->moveToElement();
        }

        if (!$xml->isEmptyElement) {
            while ($xml->read()) {
                if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == $name) break;
                if ($xml->nodeType == XMLReader::ELEMENT) {
                    array_push($extension->children, $this->parseExtension($xml, $xml->name));
                }
                if ($xml->nodeType == XMLReader::TEXT || $xml->nodeType == XMLReader::CDATA) {
                    $extension->value = $xml->value;
                }
            }
        }

        return $extension;
    }
}
