<?php

namespace A3F\Core\Components\Parsers\Html;

use A3F\Core\Components\Collections\Collection;
use Webmozart\Assert\Assert;

/**
 * class TagsCollection
 *
 * @property Tag[] $items
 */
class TagsCollection extends Collection
{
    public function __construct(array $items = [])
    {
        Assert::allIsInstanceOf($items, Tag::class);
        parent::__construct($items);
    }
}