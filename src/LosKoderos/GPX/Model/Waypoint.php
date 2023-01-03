<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Waypoint extends Model
{
    /**
     * The latitude of the point. Decimal degrees, WGS84 datum.
     */
    public ?float $latitude = null;

    /**
     * The longitude of the point. Decimal degrees, WGS84 datum.
     */
    public ?float $longitude = null;

    /**
     * Elevation (in meters) of the point.
     */
    public ?float $elevation = null;

    /**
     * UTC time.
     */
    public ?\DateTime $time = null;

    /**
     * Magnetic variation (in degrees) at the point
     */
    public ?float $magneticVariation = null;

    /**
     * Height (in meters) of geoid (mean sea level) above WGS84 earth ellipsoid. As defined in NMEA GGA message.
     */
    public ?float $geoidHeight = null;

    /**
     * The GPS name of the waypoint.
     */
    public ?string $name = null;

    /**
     * GPS waypoint comment.
=    */
    public ?string $comment = null;

    /**
     * A text description of the element.
     */
    public ?string $description = null;

    /**
     * Source of data.
     */
    public ?string $source = null;

    /**
     * Link to additional information about the waypoint.
     */
    public LinkCollection $links;

    /**
     * Text of GPS symbol name.
     */
    public ?string $symbol = null;

    /**
     * Type (classification) of the waypoint.
     */
    public ?string $type = null;

    /**
     * Type of GPX fix.
     */
    public ?string $fix = null;

    /**
     * Number of satellites used to calculate the GPX fix.
     */
    public ?int $satellites = null;

    /**
     * Horizontal dilution of precision.
     */
    public ?float $horizontalDilution = null;

    /**
     * Vertical dilution of precision.
     */
    public ?float $verticalDilution = null;

    /**
     * Position dilution of precision.
     */
    public ?float $positionDilution = null;

    /**
     * Number of seconds since last DGPS update.
     */
    public ?int $ageOfDgpsData = null;

    /**
     * ID of DGPS station used in differential correction.
     */
    public ?string $dgpsId = null;

    /**
     * Extensions.
     */
    public ExtensionCollection $extensions;

    public function __construct($mixed = null)
    {
        $this->links = new LinkCollection();
        $this->extensions = new ExtensionCollection();
        parent::__construct($mixed);
    }
}
