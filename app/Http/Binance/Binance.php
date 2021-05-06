<?php

namespace App\Http\Binance;

use App\Http\Binance\Requests\Order;
use GuzzleHttp\Client;

class Binance
{
    private $client;

    /**
     * Binance constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_url' => env('BINANCE_URL'),

        ]);
    }

    public function makeRequest(RequestInterface $request)
    {
        $this
            ->addTimestamp($request)
            ->generateSignature($request);

        $response = $request->send();

        $order = new Order('');
    }

    /**
     * For signed endpoints, the HMAC SHA256 signature is keyed with the secret key and totalParams as the value for the HMAC operation
     * totalParams is defined as the query string concatenated with the request body
     *
     * @link https://github.com/binance/binance-spot-api-docs/blob/master/rest-api.md#signed-trade-and-user_data-endpoint-security
     *
     * @param  RequestInterface  $request
     *
     * @return Binance
     */
    private function generateSignature(RequestInterface $request)
    {
        $totalParams = $request->getQueryString() . $request->getBody();

        $signature = hash_hmac('sha256', $totalParams, env('BINANCE_SECRET_KEY'));

        $request->addQueryParam('signature', $signature);

        return $this;
    }

    /**
     * Add the timestamp and recvWindow for the request.
     *
     * @link https://github.com/binance/binance-spot-api-docs/blob/master/rest-api.md#timing-security
     *
     * @param  RequestInterface  $request
     *
     * @return Binance
     */
    private function addTimestamp(RequestInterface $request)
    {
        $request->addQueryParam('recvWindow', 2000);
        $request->addQueryParam('timestamp', time() * 1000);

        return $this;
    }
}
