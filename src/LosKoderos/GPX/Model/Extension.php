<?php

namespace LosKoderos\GPX\Model;

class Extension
{
    /**
     * Name of the extension element.
     * @var string
     */
    public $name = null;

    /**
     * Attributes, key => value.
     * @var array
     */
    public $attributes = [];

    /**
     * Children nodes.
     * @var array<Extension>
     */
    public $children = [];

    /**
     * Value.
     * @var string
     */
    public $value = null;
}
