<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class TrackSegment extends Model
{
    /**
     * A Track Point holds the coordinates, elevation, timestamp, and metadata for a single point in a track.
     */
    public WaypointCollection $points;

    /**
     * Extensions.
     */
    public ExtensionCollection $extensions;

    public function __construct($mixed = null)
    {
        $this->points = new WaypointCollection();
        $this->extensions = new ExtensionCollection();
        parent::__construct($mixed);
    }
}
