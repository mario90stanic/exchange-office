<?php declare(strict_types=1);

namespace App\Factories;

use App\Interfaces\FactoryInterface;

class CurrencyFactory implements FactoryInterface
{
    public static function make(float $amount, string $name)
    {
        $currency = "App\Currencies\\" . $name;
        return new $currency($amount);
    }
}
