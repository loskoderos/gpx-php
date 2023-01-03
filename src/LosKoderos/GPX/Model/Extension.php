<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;
use LosKoderos\Generic\Collection\Collection;

class Extension extends Model
{
    /**
     * Name of the extension element.
     */
    public ?string $name = null;

    /**
     * Attributes, key => value.
     */
    public ?Collection $attributes;

    /**
     * Children nodes.
     */
    public ?ExtensionCollection $children;

    /**
     * Content, CDATA, etc.
     */
    public ?string $content = null;

    public function __construct($mixed = null) {
        $this->attributes = new Collection();
        $this->children = new ExtensionCollection();
        parent::__construct($mixed);
    }
}
