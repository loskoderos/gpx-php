<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Collection\Collection;

class TrackSegmentCollection extends Collection
{
    public function __construct($collection = null)
    {
        $this->setFilter(function ($x) {
            return $x instanceof TrackSegment ? $x : new TrackSegment($x);
        });
        $this->setValidator(function ($x) {
            return $x instanceof TrackSegment;
        });
        parent::__construct($collection);
    }
}
