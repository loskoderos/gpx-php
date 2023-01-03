<?php

namespace LosKoderos\GPX\Model;

class TrackSegment
{
    /**
     * A Track Point holds the coordinates, elevation, timestamp, and metadata for a single point in a track.
     * @var array<Waypoint>
     */
    public $points = [];

    /**
     * Extensions.
     * @var array<Extension>
     */
    public $extensions = [];
}
