<?php

namespace App\Http\Binance;

use App\Http\Binance\Exceptions\SignatureRequiredException;
use GuzzleHttp\Psr7\Request;

abstract class AbstractRequest extends Request
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
            self::METHOD,
            self::ENDPOINT
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

    public function addQueryParam(string $key, string $value): AbstractRequest
    {
        $this->queryParams[$key] = $value;

        return $this;
    }

    public function addQueryParams(array $params): AbstractRequest
    {
        $this->queryParams = array_merge($params, $this->queryParams);

        return $this;
    }

    public function validate()
    {
        if (self::SIGNED && ! isset($this->queryParams['signature'])) {
            throw new SignatureRequiredException();
        }
    }
}
