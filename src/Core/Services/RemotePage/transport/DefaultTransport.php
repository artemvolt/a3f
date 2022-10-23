<?php

namespace A3F\Core\Services\RemotePage\transport;

use A3F\Core\Services\RemotePage\Transport;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * class HeadHunterTransport
 */
class DefaultTransport implements Transport
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $url): ResponseInterface
    {
        return $this->client->withOptions([
            'headers' => $this->headersLikeAsUser()
        ])->request('GET', $url);
    }

    /**
     * @return string[]
     */
    protected function headersLikeAsUser():array {
        return [
            'User-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'text/html; charset=UTF-8',
            'X-UA-Compatible' => 'IE=edge'
        ];
    }
}