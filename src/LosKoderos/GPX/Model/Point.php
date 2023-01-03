<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Point extends Model
{
    /**
     * The latitude of the point. Decimal degrees, WGS84 datum.
     */
    public ?float $latitude = null;

    /**
     * The latitude of the point. Decimal degrees, WGS84 datum.
     */
    public ?float $longitude = null;

    /**
     * The elevation (in meters) of the point.
     */
    public ?float $elevation = null;

    /**
     * The time that the point was recorded.
     */
    public ?\DateTime $time = null;
}
