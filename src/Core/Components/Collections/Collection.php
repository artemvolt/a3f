<?php

namespace A3F\Core\Components\Collections;

use A3F\Core\Components\Parsers\Html\Tag;

/**
 * class Collection
 */
class Collection
{
    protected array $items = [];

    public function __construct(array $items = []) {
        $this->items = $items;
    }

    /**
     * @param Tag $tag
     * @return void
     */
    public function append(Tag $tag):void {
        $this->items[] = $tag;
    }

    /**
     * @return int
     */
    public function count():int
    {
        return count($this->items);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return self
     */
    public function slice(int $limit, int $offset = 0):self
    {
        return new self(
            array_slice($this->items, $offset, $limit)
        );
    }
}