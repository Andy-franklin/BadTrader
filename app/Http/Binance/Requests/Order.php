<?php

namespace App\Http\Binance\Requests;

use App\Http\Binance\AbstractRequest;
use App\Http\Binance\RequestInterface;

class Order extends AbstractRequest implements RequestInterface
{
    public const ENDPOINT = '/api/v3/order/test';
    public const METHOD = 'POST';

    /**
     * Order constructor.
     *
     * @param  string  $symbol
     * @param  string  $side
     * @param  string  $type
     * @param  string  $timeInForce
     * @param  string  $quantity
     * @param  string  $price
     * @param  string  $newClientOrderId
     */
    public function __construct(
        string $symbol,
        string $side,
        string $type,
        string $timeInForce,
        string $quantity,
        string $price,
        string $newClientOrderId
    ) {
        parent::__construct();

        $this->addQueryParams([
            'symbol' => $symbol,
            'side' => $side,
            'type' => $type,
            'timeInForce' => $timeInForce,
            'quantity' => $quantity,
            'price' => $price,
            'newClientOrderId' => $newClientOrderId
        ]);
    }
}
