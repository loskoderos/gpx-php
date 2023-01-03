<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Collection\Collection;

class RouteCollection extends Collection
{
    public function __construct($collection = null)
    {
        $this->setValidator(function ($x) {
            return $x instanceof Route;
        });
        parent::__construct($collection);
    }
}
