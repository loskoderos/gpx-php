<?php

namespace GPX\Types;

class GPX
{
    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $creator;

    /**
     * @var Metadata
     */
    protected $metadata;

    public function __construct()
    {
        $this->metadata = new Metadata();
    }

    public function setVersion(string $version)
    {
        $this->version = $version;
        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setCreator(string $creator)
    {
        $this->creator = $creator;
        return $this;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }
}
