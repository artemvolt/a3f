<?php

namespace A3F\Core\Services\RemotePage\transport;

use A3F\Core\Components\Clients\ResponseHandler;
use A3F\Core\Services\RemotePage\Transport;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * class WithResponseHandle
 */
class WithResponseHandle implements Transport
{
    private Transport $transport;
    private ResponseHandler $handler;

    public function __construct(Transport $transport, ResponseHandler $handler) {
        $this->transport = $transport;
        $this->handler = $handler;
    }

    /**
     * @param string $url
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function send(string $url): ResponseInterface
    {
        $response = $this->transport->send($url);
        $this->handler->handle($response);
        return $response;
    }
}