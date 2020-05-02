<?php

namespace GPX\Models;

class Route
{
    /**
     * GPS name of route.
     * @var string
     */
    public $name = null;

    /**
     * GPS comment for route.
     * @var string
     */
    public $comment = null;

    /**
     * Text description of route for user. Not sent to GPS.
     * @var string
     */
    public $description = null;

    /**
     * Source of data. Included to give user some idea of reliability and accuracy of data.
     * @var string
     */
    public $source = null;

    /**
     * Links to external information about the route.
     * @var array<Link>
     */
    public $links = [];

    /**
     * GPS route number.
     * @var int
     */
    public $number = null;

    /**
     * Type (classification) of route.
     * @var string
     */
    public $type = null;

    /**
     * Extensions.
     * @var array<Extension>
     */
    public $extensions = [];

    /**
     * A list of route points.
     * @var array<Waypoint>
     */
    public $points = [];
}
