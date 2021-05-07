<?php

namespace App\Http\Binance\Requests\Market;

use App\Http\Binance\AbstractRequest;

class ExchangeInfo extends AbstractRequest
{
    public const ENDPOINT = '/api/v3/exchangeInfo';
    public const METHOD = 'GET';
}
