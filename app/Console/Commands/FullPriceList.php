<?php

namespace App\Console\Commands;

use App\Http\Binance\Requests\Market\Price;
use App\Models\Symbol;
use App\Models\SymbolPrice;

class FullPriceList extends BinanceCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binance:price-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \JsonException
     */
    public function handle()
    {
        $symbols = Symbol::query()
            ->select('id', 'symbol')
            ->where('enabled', '=', true)
            ->pluck( 'id', 'symbol')
            ->toArray();

        $response = $this->binanceApi->makeRequest(new Price());

        $body = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        foreach ($body as $price) {
            if (isset($symbols[$price['symbol']])) {
                (new SymbolPrice([
                    'symbol_id' => $symbols[$price['symbol']],
                    'price' => $price['price']
                ]))->save();
            }
        }

        return 0;
    }
}
