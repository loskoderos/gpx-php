<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Collection\Collection;

class TrackCollection extends Collection
{
    public function __construct($collection = null)
    {
        $this->setValidator(function ($x) {
            return $x instanceof Track;
        });
        parent::__construct($collection);
    }
}
