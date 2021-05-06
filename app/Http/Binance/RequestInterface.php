<?php

namespace App\Http\Binance;

interface RequestInterface
{
    public function getQueryString(): ?string;

    public function getBodyString(): ?string;

    public function addQueryParam(string $key, string $value): RequestInterface;

    public function validate();
}
