<?php

namespace A3F\Core\Services\RemotePage;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface Transport
{
    public function send(string $url):ResponseInterface;
}