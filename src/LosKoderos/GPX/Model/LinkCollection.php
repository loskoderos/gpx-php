<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Collection\Collection;

class LinkCollection extends Collection
{
    public function __construct($collection = null)
    {
        $this->setFilter(function ($x) {
            return $x instanceof Link ? $x : new Link($x);
        });
        $this->setValidator(function ($x) {
            return $x instanceof Link;
        });
        parent::__construct($collection);
    }
}
