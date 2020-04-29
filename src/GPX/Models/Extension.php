<?php

namespace GPX\Models;

class Extension
{
    /**
     * Name of the extension element.
     * @var string
     */
    public $name = null;

    /**
     * Attributes, key value.
     * @var array
     */
    public $attributes = [];

    /**
     * Children nodes.
     * @var array<Extension>
     */
    public $children = [];
}
