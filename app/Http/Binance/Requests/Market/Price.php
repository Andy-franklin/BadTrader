<?php

namespace App\Http\Binance\Requests\Market;

use App\Http\Binance\AbstractRequest;

/**
 * Class Price
 * Get a list of current prices for symbols. An empty symbols array will return the default list of values.
 *
 * @package App\Http\Binance\Requests
 */
class Price extends AbstractRequest
{
    public const ENDPOINT = '/api/v3/ticker/price';
    public const METHOD = 'GET';

    public function __construct(array $symbols = [])
    {
        parent::__construct();

        if (! empty($symbols)) {
            $this->addQueryParams($symbols);
        }
    }
}
