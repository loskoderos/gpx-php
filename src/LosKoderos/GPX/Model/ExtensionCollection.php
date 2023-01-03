<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Collection\Collection;

class ExtensionCollection extends Collection
{
    public function __construct($collection = null)
    {
        $this->setValidator(function ($x) {
            return $x instanceof Extension;
        });
        parent::__construct($collection);
    }
}
