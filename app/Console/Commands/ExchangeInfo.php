<?php

namespace App\Console\Commands;

use App\Http\Binance\Requests\Market\ExchangeInfo as ExchangeInfoRequest;
use App\Models\Symbol;

class ExchangeInfo extends BinanceCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binance:exchange-info';

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
        $response = $this->binanceApi->makeRequest(new ExchangeInfoRequest());

        $body = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $existingSymbols = Symbol::query()
            ->select('symbol', 'status')
            ->whereIn('symbol', collect($body['symbols'])->pluck('symbol'))
            ->get();

        foreach ($body['symbols'] as $symbol) {
            $existing = $existingSymbols->where('symbol', '=', $symbol['symbol'])->first();

            if (null === $existing) {
                $this->createSymbol($symbol);
                continue;
            }

            if ($existing->status !== $symbol['status']) {
                //Update the existing
                $symbol->status = $symbol['status'];
                $symbol->save();
            }
        }

        return 0;
    }

    private function createSymbol(array $symbolDetails)
    {
        $symbol = new Symbol($symbolDetails);
        $symbol->enabled = false;

        $symbol->save();
    }
}
