<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Collection\Collection;

class WaypointCollection extends Collection
{
    public function __construct($collection = null)
    {
        $this->setFilter(function ($x) {
            return $x instanceof Waypoint ? $x : new Waypoint($x);
        });
        $this->setValidator(function ($x) {
            return $x instanceof Waypoint;
        });
        parent::__construct($collection);
    }
}
