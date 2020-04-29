<?php

namespace GPX\Types;

class Metadata
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $desc;

    /**
     * @var TODO
     */
    protected $author;

    /**
     * @var TODO
     */
    protected $copyright;

    /**
     * @var TODO
     */
    protected $link;

    /**
     * @var TODO
     */
    protected $time;

    /**
     * @var string
     */
    protected $keywords;

    /**
     * @var TODO
     */
    protected $bounds;

    /**
     * @var TODO
     */
    protected $extensions;

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}
