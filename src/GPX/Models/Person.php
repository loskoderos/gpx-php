<?php

namespace GPX\Models;

class Person
{
    /**
     * Name of person or organization.
     * @var string
     */
    public $name = null;

    /**
     * Email address.
     * @var Email
     */
    public $email = null;

    /**
     * Link to Web site or other external information about person.
     * @var Link
     */
    public $link;
}
