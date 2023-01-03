<?php

namespace LosKoderos\GPX\Model;

class GPX
{
    /**
     * You must include the version number in your GPX document.
     * @var string
     */
    public $version = '1.1';

    /**
     * You must include the name or URL of the software that created your GPX document.
     * This allows others to inform the creator of a GPX instance document that fails to validate.
     * @var string
     */
    public $creator = null;

    /**
     * Metadata about the file.
     * @var Metadata
     */
    public $metadata = null;

    /**
     * A list of waypoints.
     * @var array<Waypoint>
     */
    public $waypoints = [];

    /**
     * A list of routes.
     * @var array<Route>
     */
    public $routes = [];

    /**
     * A list of tracks.
     * @var array<Track>
     */
    public $tracks = [];

    /**
     * You can add extend GPX by adding your own elements from another schema here.
     * @var array<Extension>
     */
    public $extensions = [];
}
