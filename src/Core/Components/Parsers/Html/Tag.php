<?php

namespace A3F\Core\Components\Parsers\Html;

/**
 * class Tag
 */
class Tag
{
    protected string $tag;

    public function __construct(string $tag) {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }
}