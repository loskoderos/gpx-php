<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Collection\Collection;

class RouteCollection extends Collection
{
    public function __construct($collection = null)
    {
        $this->setFilter(function ($x) {
            return $x instanceof Route ? $x : new Route($x);
        });
        $this->setValidator(function ($x) {
            return $x instanceof Route;
        });
        parent::__construct($collection);
    }
}
