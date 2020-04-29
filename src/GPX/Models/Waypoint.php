<?php

namespace GPX\Models;

class Waypoint
{
    /**
     * The latitude of the point. Decimal degrees, WGS84 datum.
     * @var float
     */
    public $latitude = 0.0;

    /**
     * The longitude of the point. Decimal degrees, WGS84 datum.
     * @var float
     */
    public $longitude;

    /**
     * Elevation (in meters) of the point.
     * @var float
     */
    public $elevation = null;

    /**
     * UTC time.
     * @var \DateTime
     */
    public $time = null;

    /**
     * Magnetic variation (in degrees) at the point
     * @var float
     */
    public $magneticVariation = null;

    /**
     * Height (in meters) of geoid (mean sea level) above WGS84 earth ellipsoid. As defined in NMEA GGA message.
     * @var float
     */
    public $geoidHeight = null;

    /**
     * The GPS name of the waypoint.
     * @var string
     */
    public $name = null;

    /**
     * GPS waypoint comment.
     * @var string
     */
    public $comment = null;

    /**
     * A text description of the element.
     * @var string
     */
    public $description = null;

    /**
     * Source of data.
     * @var string
     */
    public $source = null;

    /**
     * Link to additional information about the waypoint.
     * @var array<Link>
     */
    public $links = [];

    /**
     * Text of GPS symbol name.
     * @var string
     */
    public $symbol = null;

    /**
     * Type (classification) of the waypoint.
     * @var string
     */
    public $type = null;

    /**
     * Type of GPX fix.
     * @var string
     */
    public $fix = null;

    /**
     * Number of satellites used to calculate the GPX fix.
     * @var int
     */
    public $satellites = null;

    /**
     * Horizontal dilution of precision.
     * @var float
     */
    public $horizontalDilution = null;

    /**
     * Vertical dilution of precision.
     * @var float
     */
    public $verticalDilution = null;

    /**
     * Position dilution of precision.
     * @var float
     */
    public $positionDilution = null;

    /**
     * Number of seconds since last DGPS update.
     * @var int
     */
    public $ageOfDgpsData = null;

    /**
     * ID of DGPS station used in differential correction.
     * @var string
     */
    public $dgpsId = null;

    /**
     * Extentions.
     * @var array
     */
    public $extentions = [];
}
