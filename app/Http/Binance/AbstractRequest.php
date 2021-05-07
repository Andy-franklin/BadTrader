<?php

namespace App\Http\Binance;

use App\Http\Binance\Exceptions\SignatureRequiredException;
use GuzzleHttp\Psr7\Request;

abstract class AbstractRequest extends Request implements RequestInterface
{
    public const ENDPOINT = '';
    public const METHOD = '';

    private const SIGNED = false;

    private $queryParams = [];

    private $bodyParams = [];

    /**
     * AbstractRequest constructor.
     */
    public function __construct()
    {
        parent::__construct(
            static::METHOD,
            static::ENDPOINT
        );
    }

    public function getQueryString(): ?string
    {
        return http_build_query($this->queryParams);
    }

    public function getBodyString(): ?string
    {
        $encoded = http_request_body_encode($this->bodyParams, []);

        if (false === $encoded) {
            return '';
        }

        return $encoded;
    }

    public function addQueryParam(string $key, string $value): RequestInterface
    {
        $this->queryParams[$key] = $value;

        return $this;
    }

    public function addQueryParams(array $params): RequestInterface
    {
        $this->queryParams = array_merge($params, $this->queryParams);

        return $this;
    }

    public function prepare(): RequestInterface
    {
        $this->addTimestamp();

        if (static::SIGNED) {
            if (! isset($this->queryParams['signature'])) {
                throw new SignatureRequiredException();
            }

            $this->generateSignature();
        }

        return $this;
    }

    /**
     * For signed endpoints, the HMAC SHA256 signature is keyed with the secret key and totalParams as the value for the HMAC operation
     * totalParams is defined as the query string concatenated with the request body
     *
     * @link https://github.com/binance/binance-spot-api-docs/blob/master/rest-api.md#signed-trade-and-user_data-endpoint-security
     *
     * @return AbstractRequest
     */
    public function generateSignature()
    {
        $totalParams = $this->getQueryString() . $this->getBody();

        $signature = hash_hmac('sha256', $totalParams, env('BINANCE_SECRET_KEY'));

        $this->addQueryParam('signature', $signature);

        return $this;
    }

    /**
     * Add the timestamp and recvWindow for the request.
     *
     * @link https://github.com/binance/binance-spot-api-docs/blob/master/rest-api.md#timing-security
     *
     * @return AbstractRequest
     */
    public function addTimestamp()
    {
        $this->addQueryParam('recvWindow', 2000);
        $this->addQueryParam('timestamp', time() * 1000);

        return $this;
    }

    public function getMethod()
    {
        return static::METHOD;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
}
