<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\UserSymbolRequest;
use App\Models\Symbol;
use App\Models\UserSymbol;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserSymbolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {

        $userPreferences = UserSymbol::query()
            ->select([
                'symbols.symbol as symbolName',
                'symbols.quoteAsset',
                'symbols.baseAsset',
                'symbols.id as symbol_id',
                'user_symbols.*'
            ])
            ->join('symbols', 'symbols.id', '=', 'user_symbols.symbol_id')
            ->where('user_id', '=', auth()->user()->id)
            ->orderBy('user_symbols.enabled')
            ->get();

        $enabledSymbols = Symbol::systemEnabledSymbols()->whereNotIn('id', $userPreferences->pluck('symbols.symbol_id'));


        return Inertia::render('User/UserSymbol', [
            'systemEnabledSymbols' => $enabledSymbols,
            'userSymbols' => $userPreferences
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserSymbolRequest  $request
     * @param  Symbol  $symbol
     *
     * @return JsonResponse
     */
    public function createOrUpdate(UserSymbolRequest $request, Symbol $symbol)
    {
        $userSymbol = UserSymbol::query()
            ->where('user_id', '=', auth()->user()->id)
            ->where('symbol_id', '=', $symbol->id)
            ->first();

        if (null === $userSymbol) {
            UserSymbol::create(
                array_merge($request->validated(), [
                    'symbol_id' => $symbol->id,
                    'user_id' => auth()->user()->id,
                ])
            );

            return new JsonResponse(null, JsonResponse::HTTP_CREATED);
        }

        $userSymbol->update($request->validated());

        return new JsonResponse(null, JsonResponse::HTTP_OK);
    }
}
