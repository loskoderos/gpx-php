<?php

namespace LosKoderos\GPX;

use LosKoderos\GPX\Model\Bounds;
use LosKoderos\GPX\Model\Copyright;
use LosKoderos\GPX\Model\Email;
use LosKoderos\GPX\Model\Extension;
use LosKoderos\GPX\Model\ExtensionCollection;
use LosKoderos\GPX\Model\GPX;
use LosKoderos\GPX\Model\Link;
use LosKoderos\GPX\Model\Metadata;
use LosKoderos\GPX\Model\Person;
use LosKoderos\GPX\Model\Route;
use LosKoderos\GPX\Model\Track;
use LosKoderos\GPX\Model\TrackSegment;
use LosKoderos\GPX\Model\Waypoint;
use XMLWriter;

class GPXWriter
{
    const GPX_XMLNS = 'http://www.topografix.com/GPX/1/1';

    public function writeToFile(GPX $gpx, string $filename)
    {
        $xml = new XMLWriter();
        $xml->openUri($filename);
        $this->write($gpx, $xml);
        $xml->flush();
    }

    public function writeToString(GPX $gpx): string
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $this->write($gpx, $xml);
        return $xml->flush();
    }

    protected function write(GPX $gpx, XMLWriter $xml)
    {
        $xml->startDocument('1.0', 'utf-8');

        $xml->startElement('gpx');
        $xml->writeAttribute('creator', $gpx->creator);
        $xml->writeAttribute('version', $gpx->version);
        $xml->writeAttribute('xmlns', self::GPX_XMLNS);

        if (null !== $gpx->metadata) $this->writeMetadata($gpx->metadata, $xml);
        foreach ($gpx->waypoints as $waypoint) $this->writeWaypoint($waypoint, $xml);
        foreach ($gpx->routes as $route) $this->writeRoute($route, $xml);
        foreach ($gpx->tracks as $track) $this->writeTrack($track, $xml);
        if (null !== $gpx->extensions) $this->writeExtensions($gpx->extensions, $xml);

        $xml->endElement();
    }

    protected function writeMetadata(Metadata $metadata, XMLWriter $xml, string $tag = 'metadata')
    {
        $xml->startElement($tag);
        if (null !== $metadata->name) $xml->writeElement('name', $metadata->name);
        if (null !== $metadata->description) $xml->writeElement('desc', $metadata->description);
        if (null !== $metadata->author) $this->writePerson($metadata->author, $xml, 'author');
        if (null !== $metadata->copyright) $this->writeCopyright($metadata->copyright, $xml);
        foreach ($metadata->links as $link) $this->writeLink($link, $xml);
        if (null !== $metadata->time) $this->writeTime($metadata->time, $xml);
        if (null !== $metadata->keywords) $xml->writeElement('keywords', $metadata->keywords);
        if (null !== $metadata->bounds) $this->writeBounds($metadata->bounds, $xml);
        if (null !== $metadata->extensions) $this->writeExtensions($metadata->extensions, $xml);
        $xml->endElement();
    }

    protected function writeWaypoint(Waypoint $waypoint, XMLWriter $xml, string $tag = 'wpt')
    {
        $xml->startElement($tag);
        $xml->writeAttribute('lat', $waypoint->latitude);
        $xml->writeAttribute('lon', $waypoint->longitude);
        if (null !== $waypoint->elevation) $xml->writeElement('ele', $waypoint->elevation);
        if (null !== $waypoint->time) $this->writeTime($waypoint->time, $xml);
        if (null !== $waypoint->magneticVariation) $xml->writeElement('magvar', $waypoint->magneticVariation);
        if (null !== $waypoint->geoidHeight) $xml->writeElement('geoidheight', $waypoint->geoidHeight);
        if (null !== $waypoint->name) $xml->writeElement('name', $waypoint->name);
        if (null !== $waypoint->comment) $xml->writeElement('cmt', $waypoint->comment);
        if (null !== $waypoint->description) $xml->writeElement('desc', $waypoint->description);
        if (null !== $waypoint->source) $xml->writeElement('src', $waypoint->source);
        foreach ($waypoint->links as $link) $this->writeLink($link, $xml);
        if (null !== $waypoint->symbol) $xml->writeElement('sym', $waypoint->symbol);
        if (null !== $waypoint->type) $xml->writeElement('type', $waypoint->type);
        if (null !== $waypoint->fix) $xml->writeElement('fix', $waypoint->fix);
        if (null !== $waypoint->satellites) $xml->writeElement('sat', $waypoint->satellites);
        if (null !== $waypoint->horizontalDilution) $xml->writeElement('hdop', $waypoint->horizontalDilution);
        if (null !== $waypoint->verticalDilution) $xml->writeElement('vdop', $waypoint->verticalDilution);
        if (null !== $waypoint->positionDilution) $xml->writeElement('pdop', $waypoint->positionDilution);
        if (null !== $waypoint->ageOfDgpsData) $xml->writeElement('ageofdgpsdata', $waypoint->ageOfDgpsData);
        if (null !== $waypoint->dgpsId) $xml->writeElement('dgpsid', $waypoint->dgpsId);
        if (null !== $waypoint->extensions) $this->writeExtensions($waypoint->extensions, $xml);
        $xml->endElement();
    }

    protected function writeRoute(Route $route, XMLWriter $xml, string $tag = 'rte')
    {
        $xml->startElement($tag);
        if (null !== $route->name) $xml->writeElement('name', $route->name);
        if (null !== $route->comment) $xml->writeElement('cmt', $route->comment);
        if (null !== $route->description) $xml->writeElement('desc', $route->description);
        if (null !== $route->source) $xml->writeElement('src', $route->source);
        foreach ($route->links as $link) $this->writeLink($link, $xml);
        if (null !== $route->number) $xml->writeElement('number', $route->number);
        if (null !== $route->type) $xml->writeElement('type', $route->type);
        if (null !== $route->extensions) $this->writeExtensions($route->extensions, $xml);
        foreach ($route->points as $point) $this->writeWaypoint($point, $xml, 'rtept');
        $xml->endElement();
    }

    protected function writeTrack(Track $track, XMLWriter $xml, string $tag = 'trk')
    {
        $xml->startElement($tag);
        if (null !== $track->name) $xml->writeElement('name', $track->name);
        if (null !== $track->comment) $xml->writeElement('cmt', $track->comment);
        if (null !== $track->description) $xml->writeElement('desc', $track->description);
        if (null !== $track->source) $xml->writeElement('src', $track->source);
        foreach ($track->links as $link) $this->writeLink($link, $xml);
        if (null !== $track->number) $xml->writeElement('number', $track->number);
        if (null !== $track->type) $xml->writeElement('type', $track->type);
        if (null !== $track->extensions) $this->writeExtensions($track->extensions, $xml);
        foreach ($track->segments as $segment) $this->writeTrackSegment($segment, $xml);
        $xml->endElement();
    }

    protected function writeTrackSegment(TrackSegment $segment, XMLWriter $xml, string $tag = 'trkseg')
    {
        $xml->startElement($tag);
        foreach ($segment->points as $point) $this->writeWaypoint($point, $xml, 'trkpt');
        if (null !== $segment->extensions) $this->writeExtensions($segment->extensions, $xml);
        $xml->endElement();
    }

    protected function writeExtensions(ExtensionCollection $extensions, XMLWriter $xml, string $tag = 'extensions')
    {
        if (count($extensions) == 0) return;
        $xml->startElement($tag);
        foreach ($extensions as $extension) $this->writeExtension($extension, $xml);
        $xml->endElement();
    }

    protected function writeExtension(Extension $extension, XMLWriter $xml)
    {
        $xml->startElement($extension->name);
        foreach ($extension->attributes as $k => $v) $xml->writeAttribute($k, $v);
        foreach ($extension->children as $child) $this->writeExtension($child, $xml);
        if (null !== $extension->content) $xml->writeRaw($extension->content);
        $xml->endElement();
    }

    protected function writePerson(Person $person, XMLWriter $xml, string $tag = 'person')
    {
      $xml->startElement($tag);
      if (null !== $person->name) $xml->writeElement('name', $person->name);
      if (null !== $person->email) $this->writeEmail($person->email, $xml);
      if (null !== $person->link) $this->writeLink($person->link, $xml);
      $xml->endElement();
    }

    protected function writeEmail(Email $email, XMLWriter $xml, string $tag = 'email')
    {
        $xml->startElement($tag);
        $xml->writeAttribute('id', $email->id);
        $xml->writeAttribute('domain', $email->domain);
        $xml->endElement();
    }

    protected function writeLink(Link $link, XMLWriter $xml, string $tag = 'link')
    {
        $xml->startElement($tag);
        $xml->writeAttribute('href', $link->href);
        if (null !== $link->text) $xml->writeElement('text', $link->text);
        if (null !== $link->type) $xml->writeElement('type', $link->type);
        $xml->endElement();
    }

    protected function writeCopyright(Copyright $copyright, XMLWriter $xml, string $tag = 'copyright')
    {
        $xml->startElement($tag);
        $xml->writeAttribute('author', $copyright->author);
        if (null !== $copyright->year) $xml->writeElement('year', $copyright->year);
        if (null !== $copyright->license) $xml->writeElement('license', $copyright->license);
        $xml->endElement();
    }

    protected function writeTime(\DateTime $dt, XMLWriter $xml, string $tag = 'time')
    {
        $xml->writeElement($tag, $dt->format(\DateTime::ISO8601));
    }

    protected function writeBounds(Bounds $bounds, XMLWriter $xml, string $tag = 'bounds')
    {
        $xml->startElement($tag);
        $xml->writeAttribute('minlat', $bounds->minLatitude);
        $xml->writeAttribute('minlon', $bounds->minLongitude);
        $xml->writeAttribute('maxlat', $bounds->maxLatitude);
        $xml->writeAttribute('maxlon', $bounds->maxLongitude);
        $xml->endElement();
    }
}
