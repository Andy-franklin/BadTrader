<?php

namespace App\Http\Binance;

interface RequestInterface extends \Psr\Http\Message\RequestInterface
{
    public function getQueryString(): ?string;

    public function getQueryParams(): array;

    public function getBodyString(): ?string;

    public function addQueryParam(string $key, string $value): RequestInterface;

    public function addQueryParams(array $values): RequestInterface;

    public function prepare(): RequestInterface;
}
