<?php

namespace App\Http\Binance\Requests\Trade;

use App\Http\Binance\AbstractRequest;

/**
 * Class OrderTest
 * "Place" an order for a symbol.
 * Returns the exact same as an actual order without actually placing an order.
 * Any validation errors would be returned.
 *
 * @package App\Http\Binance\Requests
 */
class OrderTest extends AbstractRequest
{
    public const ENDPOINT = '/api/v3/order/test';
}
