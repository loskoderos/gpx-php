<?php

namespace LosKoderos\GPX\Model;

use LosKoderos\Generic\Model\Model;

class Link extends Model
{
    /**
     * URL of hyperlink.
     */
    public ?string $href = null;

    /**
     * Text of hyperlink.
     */
    public ?string $text = null;

    /**
     * Mime type of content (image/jpeg)
     */
    public ?string $type = null;
}
