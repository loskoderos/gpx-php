<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Route extends Model
{
    /**
     * GPS name of route.
     */
    public ?string $name = null;

    /**
     * GPS comment for route.
     */
    public ?string $comment = null;

    /**
     * Text description of route for user. Not sent to GPS.
     */
    public ?string $description = null;

    /**
     * Source of data. Included to give user some idea of reliability and accuracy of data.
     */
    public ?string $source = null;

    /**
     * Links to external information about the route.
     */
    public LinkCollection $links;

    /**
     * GPS route number.
     */
    public ?int $number = null;

    /**
     * Type (classification) of route.
     */
    public ?string $type = null;

    /**
     * Extensions.
     */
    public ExtensionCollection $extensions;

    /**
     * A list of route points.
     */
    public WaypointCollection $points;

    public function __construct($mixed = null) {
        $this->links = new LinkCollection();
        $this->extensions = new ExtensionCollection();
        $this->points = new WaypointCollection();
        parent::__construct($mixed);
    }
}
