<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Collection\Collection;

class SegmentCollection extends Collection
{
    public function __construct($collection = null)
    {
        $this->setValidator(function ($x) {
            return $x instanceof Segment;
        });
        parent::__construct($collection);
    }
}
