<?php

namespace App\Http\Binance;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Binance
{
    private $client;

    /**
     * Binance constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('BINANCE_URL'),
        ]);
    }

    public function makeRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->send($request, [
            'query' => $request->getQueryParams()
        ]);
    }
}
