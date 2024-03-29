<?php

namespace LosKoderos\GPX;

use LosKoderos\GPX\Model\Bounds;
use LosKoderos\GPX\Model\Copyright;
use LosKoderos\GPX\Model\Email;
use LosKoderos\GPX\Model\Extension;
use LosKoderos\GPX\Model\ExtensionCollection;
use LosKoderos\GPX\Model\Link;
use LosKoderos\GPX\Model\Metadata;
use LosKoderos\GPX\Model\GPX;
use LosKoderos\GPX\Model\Person;
use LosKoderos\GPX\Model\Route;
use LosKoderos\GPX\Model\Track;
use LosKoderos\GPX\Model\TrackSegment;
use LosKoderos\GPX\Model\Waypoint;
use XMLReader;

class GPXReader
{
    public function readFromFile(string $filename): GPX
    {
        return $this->read(XMLReader::open($filename));
    }

    public function readFromString(string $content): GPX
    {
        return $this->read(XMLReader::XML($content));
    }

    protected function read(XMLReader $xml): GPX
    {
        $gpx = new GPX();

        while ($xml->read()) {

            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'gpx':
                        $gpx->version = $xml->getAttribute('version');
                        $gpx->creator = $xml->getAttribute('creator');
                        break;

                    case 'metadata':
                        $gpx->metadata = $this->readMetadata($xml);
                        break;

                    case 'wpt':
                        $gpx->waypoints->add($this->readWaypoint($xml, 'wpt'));
                        break;

                    case 'rte':
                        $gpx->routes->add($this->readRoute($xml));
                        break;

                    case 'trk':
                        $gpx->tracks->add($this->readTrack($xml));
                        break;
                }
            }
        }

        $xml->close();

        return $gpx;
    }

    protected function readMetadata(XMLReader $xml): Metadata
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
                        $metadata->author = $this->readAuthor($xml);
                        break;

                    case 'copyright':
                        $metadata->copyright = $this->readCopyright($xml);
                        break;

                    case 'link':
                        $metadata->links->add($this->readLink($xml));
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
                        $metadata->extensions = $this->readExtensions($xml);
                        break;
                }
            }
        }

        return $metadata;
    }

    protected function readLink(XMLReader $xml): Link
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

    protected function readAuthor(XMLReader $xml): Person
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
                        $author->link = $this->readLink($xml);
                        break;
                }
            }
        }

        return $author;
    }

    protected function readCopyright(XMLReader $xml): Copyright
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

    protected function readWaypoint(XMLReader $xml, string $name): Waypoint
    {
        $waypoint = new Waypoint();
        $waypoint->latitude = (float) $xml->getAttribute('lat');
        $waypoint->longitude = (float) $xml->getAttribute('lon');

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
                        $waypoint->links->add($this->readLink($xml));
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
                        $waypoint->extensions = $this->readExtensions($xml);
                        break;
                }
            }
        }

        return $waypoint;
    }

    protected function readRoute(XMLReader $xml): Route
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
                        $route->links->add($this->readLink($xml));
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
                        $route->points->add($this->readWaypoint($xml, 'rtept'));
                        break;

                    case 'extensions':
                        $route->extensions = $this->readExtensions($xml);
                        break;
                }
            }
        }

        return $route;
    }

    protected function readTrack(XMLReader $xml): Track
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
                        $track->links->add($this->readLink($xml));
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
                        $track->segments->add($this->readTrackSegment($xml));
                        break;

                    case 'extensions':
                        $track->extensions = $this->readExtensions($xml);
                        break;
                }
            }
        }

        return $track;
    }

    protected function readTrackSegment(XMLReader $xml): TrackSegment
    {
        $segment = new TrackSegment();

        if ($xml->isEmptyElement) return $segment;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'trkseg') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                switch ($xml->name) {
                    case 'trkpt':
                        $segment->points->add($this->readWaypoint($xml, 'trkpt'));
                        break;

                    case 'extensions':
                        $segment->extensions->add($this->readExtensions($xml));
                        break;
                }
            }
        }

        return $segment;
    }

    protected function readExtensions(XMLReader $xml): ExtensionCollection
    {
        $extensions = new ExtensionCollection();

        if ($xml->isEmptyElement) return $extensions;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT && $xml->name == 'extensions') break;
            if ($xml->nodeType == XMLReader::ELEMENT) {
                $extensions->add($this->readExtension($xml, $xml->name));
            }
        }

        return $extensions;
    }

    protected function readExtension(XMLReader $xml, string $name): Extension
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
                    $extension->children->add($this->readExtension($xml, $xml->name));
                }
                if ($xml->nodeType == XMLReader::TEXT || $xml->nodeType == XMLReader::CDATA) {
                    $extension->content = $xml->value;
                }
            }
        }

        return $extension;
    }
}
