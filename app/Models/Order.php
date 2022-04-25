<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'foreign_currency_purchased',
        'foreign_currency_exchange_rate',
        'surcharge_percentage',
        'surcharge_amount',
        'foreign_currency_amount',
        'amount_in_usd',
        'discount_percentage',
        'discount_amount',
        'created_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->setCreatedAt($model->freshTimestamp());
        });
    }
}
