<?php

namespace GPX\Models;

class Copyright
{
    /**
     * Copyright holder (TopoSoft, Inc.)
     * @var string
     */
    public $author = null;

    /**
     * Year of copyright.
     * @var int
     */
    public $year = null;

    /**
     * Link to external file containing license text.
     * @var string
     */
    public $license = null;
}
