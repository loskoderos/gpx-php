<?php

namespace GPX\Types;

class GPX
{
    /**
     * @var string
     */
    protected $version;

    public function setVersion(string $version)
    {
        $this->version = $version;
        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }
}
