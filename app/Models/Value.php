<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\FetchingCurrenciesFailed;
class Value extends Model
{
    use HasFactory;

    protected $casts = [
        'foreign_currency_exchange_rate' => 'float',
        'surcharge_percentage' => 'float',
        'surcharge_amount' => 'float',
        'foreign_currency_amount' => 'float',
        'amount_in_usd' => 'float',
        'discount_percentage' => 'float',
        'discount_amount' => 'float',
    ];

    /**
     * @throws \Exception
     */
    public static function getValueNames()
    {
        $values = Value::select('name')
            ->pluck('name');

        if ($values->isEmpty()) return throw new FetchingCurrenciesFailed();

        return $values;
    }
}
