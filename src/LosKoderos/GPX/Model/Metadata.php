<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Metadata extends Model
{
    /**
     * The name of the GPX file.
     */
    public ?string $name = null;

    /**
     * A description of the contents of the GPX file.
     */
    public ?string $description = null;

    /**
     * The person or organization who created the GPX file.
     */
    public ?Person $author = null;

    /**
     * Copyright and license information governing use of the file.
     */
    public ?Copyright $copyright = null;

    /**
     * URLs associated with the location described in the file.
     */
    public LinkCollection $links;

    /**
     * The creation date of the file.
     */
    public ?\DateTime $time = null;

    /**
     * Keywords associated with the file. Search engines or databases can use this information to classify the data.
     */
    public ?string $keywords = null;

    /**
     * Minimum and maximum coordinates which describe the extent of the coordinates in the file.
     */
    public ?Bounds $bounds = null;

    /**
     * Extensions.
     */
    public ExtensionCollection $extensions;

    public function __construct($mixed = null)
    {
        $this->links = new LinkCollection();
        $this->extensions = new ExtensionCollection();
        parent::__construct($mixed);
    }
}
