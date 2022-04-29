<?php declare(strict_types=1);

namespace App\Models;

use App\Currencies\CurrencyParent;
use App\Exceptions\FetchingCurrenciesFailed;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $array)
 */
class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'foreign_currency_purchased',
        'foreign_currency_exchange_rate',
        'surcharge_percentage',
        'surcharge_amount',
        'foreign_currency_amount',
        'amount_in_usd',
        'discount_percentage',
        'discount_amount',
    ];

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
     * @throws FetchingCurrenciesFailed
     */
    public static function make(CurrencyParent $currency)
    {
        return Order::create([
            'foreign_currency_purchased' => $currency->getCurrency()->name,
            'foreign_currency_exchange_rate' => $currency->getCurrency()->rate,
            'surcharge_percentage' => $currency->getCurrency()->surcharge,
            'surcharge_amount' => $currency->getSurchargeAmount(),
            'foreign_currency_amount' => $currency->getAmount(),
            'amount_in_usd' => $currency->getCalculatedWithSurcharge(),
            'discount_percentage' => $currency->getCurrency()->discount,
            'discount_amount' => $currency->getDiscountAmount(),
            'created_at' => Carbon::now()
        ]);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->setCreatedAt($model->freshTimestamp());
        });
    }
}
