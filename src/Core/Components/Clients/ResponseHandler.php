<?php

namespace A3F\Core\Components\Clients;

use RuntimeException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * class ResponseHandler
 */
class ResponseHandler
{
    /**
     * @param ResponseInterface $response
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function handle(ResponseInterface $response):void
    {
       $responseStatus = $response->getStatusCode();
       if ($responseStatus !== 200) {
           $content = $response->getContent(false);
           throw new RuntimeException("Remote server with another response code: $responseStatus. $content");
       }
    }
}