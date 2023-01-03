<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class GPX extends Model
{
    /**
     * You must include the version number in your GPX document.
     */
    public string $version = '1.1';

    /**
     * You must include the name or URL of the software that created your GPX document.
     * This allows others to inform the creator of a GPX instance document that fails to validate.
     */
    public ?string $creator = null;

    /**
     * Metadata about the file.
     */
    public ?Metadata $metadata = null;

    /**
     * A list of waypoints.
     */
    public WaypointCollection $waypoints;

    /**
     * A list of routes.
     */
    public RouteCollection $routes;

    /**
     * A list of tracks.
     */
    public TrackCollection $tracks;

    /**
     * You can add extend GPX by adding your own elements from another schema here.
     */
    public ExtensionCollection $extensions;

    public function __construct($mixed = null)
    {
        $this->waypoints = new WaypointCollection();
        $this->routes = new RouteCollection();
        $this->tracks = new TrackCollection();
        $this->extensions = new ExtensionCollection();
        parent::__construct($mixed);
    }
}
