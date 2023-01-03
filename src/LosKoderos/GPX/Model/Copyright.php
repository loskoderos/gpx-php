<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Copyright extends Model
{
    /**
     * Copyright holder (TopoSoft, Inc.)
     */
    public ?string $author = null;

    /**
     * Year of copyright.
     */
    public ?int $year = null;

    /**
     * Link to external file containing license text.
     */
    public ?string $license = null;
}
