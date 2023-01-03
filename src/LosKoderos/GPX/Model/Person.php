<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Person extends Model
{
    /**
     * Name of person or organization.
     */
    public ?string $name = null;

    /**
     * Email address.
     */
    public ?Email $email = null;

    /**
     * Link to Web site or other external information about person.
     */
    public ?Link $link = null;
}
