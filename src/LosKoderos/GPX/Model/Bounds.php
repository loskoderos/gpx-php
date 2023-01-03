<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Bounds extends Model
{
    /**
     * The minimum latitude.
     */
    public ?float $minLatitude = null;

    /**
     * The minimum longitude.
     */
    public ?float $minLongitude = null;

    /**
     * The maximum latitude.
     */
    public ?float $maxLatitude = null;

    /**
     * The maximum longitude.
     */
    public ?float $maxLongitude = null;
}
