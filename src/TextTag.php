<?php

namespace Comsolit\HTMLBuilder;

class TextTag extends HTMLBuilder
{

    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function build()
    {
        return $this->text;
    }
}
