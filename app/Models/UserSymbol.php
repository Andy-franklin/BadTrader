<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserSymbol extends Model
{
    use HasFactory;

    protected $fillable = [
        'enabled',
        'bullish',
        'bearish',
        'fiat_max_allocation',
        'cool_off_period',
        'symbol_id',
        'user_id',
    ];

    public function symbol(): HasOne
    {
        return $this->hasOne(Symbol::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
