<?php

namespace A3F\Core\Services\RemotePage;

/**
 * class Request
 */
class Request
{
    public string $url;

    public function __construct(string $url) {
        $this->url = $url;
    }
}