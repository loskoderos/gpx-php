<?php

namespace GPX\Models;

class Track
{
    /**
     * GPS name of track.
     * @var string
     */
    public $name = null;

    /**
     * GPS comment for track.
     * @var string
     */
    public $comment = null;

    /**
     * User description of track.
     * @var string
     */
    public $description = null;

    /**
     * Source of data. Included to give user some idea of reliability and accuracy of data.
     * @var string.
     */
    public $source;

    /**
     * Links to external information about track.
     * @var array<Link>
     */
    public $links = [];

    /**
     * GPS track number.
     * @var int
     */
    public $number = null;

    /**
     * Type (classification) of track.
     * @var string
     */
    public $type = null;

    /**
     * Extensions.
     * @var array<Extension>
     */
    public $extensions = [];

    /**
     * A Track Segment holds a list of Track Points which are logically connected in order.
     * @var array<TrackSegment>
     */
    public $segments = [];
}
