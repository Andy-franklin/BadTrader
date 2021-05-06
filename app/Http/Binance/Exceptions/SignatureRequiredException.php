<?php

namespace App\Http\Binance\Exceptions;

class SignatureRequiredException extends \RuntimeException
{
    protected $message = 'A signature is required to make this request.';
}
