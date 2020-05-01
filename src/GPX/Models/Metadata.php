<?php

namespace GPX\Models;

class Metadata
{
    /**
     * The name of the GPX file.
     * @var string
     */
    public $name = null;

    /**
     * A description of the contents of the GPX file.
     * @var string
     */
    public $description = null;

    /**
     * The person or organization who created the GPX file.
     * @var Person
     */
    public $author = null;

    /**
     * Copyright and license information governing use of the file.
     * @var Copyright
     */
    public $copyright = null;

    /**
     * URLs associated with the location described in the file.
     * @var array<Link>
     */
    public $links = [];

    /**
     * The creation date of the file.
     * @var \DateTime
     */
    public $time = null;

    /**
     * Keywords associated with the file. Search engines or databases can use this information to classify the data.
     * @var string
     */
    public $keywords = null;

    /**
     * Minimum and maximum coordinates which describe the extent of the coordinates in the file.
     * @var Bounds
     */
    public $bounds = null;

    /**
     * Extensions.
     * @var array<Extension>
     */
    public $extensions;
}
