<?php

namespace App\Http\Binance\Requests\Trade;

use App\Http\Binance\AbstractRequest;

/**
 * Class Order
 * Place an order for a symbol.
 *
 * @package App\Http\Binance\Requests
 */
class Order extends AbstractRequest
{
    public const ENDPOINT = '/api/v3/order';
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
        throw new \Exception('Are you sure? Maybe just some ore testing with OrderTest class instead...');

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
