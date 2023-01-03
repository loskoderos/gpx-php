<?php

namespace LosKoderos\GPX\Model;

class Point
{
    /**
     * The latitude of the point. Decimal degrees, WGS84 datum.
     * @var float
     */
    public $latitude = 0.0;

    /**
     * The latitude of the point. Decimal degrees, WGS84 datum.
     * @var float
     */
    public $longitude = 0.0;

    /**
     * The elevation (in meters) of the point.
     * @var float
     */
    public $elevation = null;

    /**
     * The time that the point was recorded.
     * @var \DateTime
     */
    public $time = null;
}
