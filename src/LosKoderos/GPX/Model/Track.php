<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Track extends Model
{
    /**
     * GPS name of track.
     */
    public ?string $name = null;

    /**
     * GPS comment for track.
     */
    public ?string $comment = null;

    /**
     * User description of track.
     */
    public ?string $description = null;

    /**
     * Source of data. Included to give user some idea of reliability and accuracy of data.
     */
    public ?string $source;

    /**
     * Links to external information about track.
     */
    public LinkCollection $links;

    /**
     * GPS track number.
     */
    public ?int $number = null;

    /**
     * Type (classification) of track.
     */
    public ?string $type = null;

    /**
     * Extensions.
     */
    public ExtensionCollection $extensions;

    /**
     * A Track Segment holds a list of Track Points which are logically connected in order.
     */
    public SegmentCollection $segments;

    public function __construct($mixed = null)
    {
        $this->links = new LinkCollection();
        $this->extensions = new ExtensionCollection();
        $this->segments = new SegmentCollection();
        parent::__construct($mixed);
    }
}
