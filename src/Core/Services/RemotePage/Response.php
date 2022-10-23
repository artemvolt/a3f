<?php

namespace A3F\Core\Services\RemotePage;

use A3F\Core\Components\Parsers\Html\TagsCollection;
use A3F\Core\Services\Response as BaseResponse;

/**
 * class Response
 */
class Response extends BaseResponse
{
    public TagsCollection $tags;

    public function countTags(): int
    {
        return $this->tags->count();
    }
}