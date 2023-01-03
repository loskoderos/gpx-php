<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Email extends Model
{
    /**
     * The id half of email address (billgates2004).
     */
    public ?string $id = null;

    /**
     * The domain half of email address (hotmail.com)
     */
    public ?string $domain = null;
}
