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
}
