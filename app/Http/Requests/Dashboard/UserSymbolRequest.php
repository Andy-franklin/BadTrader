<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserSymbolRequest extends FormRequest
{
    public function rules()
    {
        return [
            'enabled' => 'required|boolean',
            'bullish' => 'required|boolean',
            'bearish' => 'required|boolean',
            'fiat_max_allocation' => 'required|numeric',
            'cool_off_period' => 'required|numeric',
        ];
    }
}
