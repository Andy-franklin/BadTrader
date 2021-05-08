<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Symbol extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'status',
        'baseAsset',
        'baseAssetPrecision',
        'quoteAsset',
        'quoteAssetPrecision',
        'quotePrecision',
        'isSpotTradingAllowed',
        'isMarginTradingAllowed',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(SymbolPrice::class);
    }

    public function userSymbols(): HasMany
    {
        return $this->hasMany(UserSymbol::class);
    }

    public static function systemEnabledSymbols()
    {
        return self::query()
            ->select(['id', 'symbol as symbolName', 'baseAsset', 'quoteAsset', 'isSpotTradingAllowed', 'isMarginTradingAllowed'])
            ->where('enabled', true)
            ->get();
    }
}
