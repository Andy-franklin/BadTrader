<?php

namespace App\Console\Commands;

use App\Http\Binance\Binance;
use Illuminate\Console\Command;

abstract class BinanceCommand extends Command
{
    /**
     * @var Binance
     */
    protected $binanceApi;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->binanceApi = new Binance();
    }
}
