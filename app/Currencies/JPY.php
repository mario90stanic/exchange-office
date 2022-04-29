<?php declare(strict_types=1);

namespace App\Currencies;

use App\Interfaces\CurrencyInterface;

class JPY extends CurrencyParent implements CurrencyInterface
{
    protected float $surcharge = 0.075;

    public function action()
    {
        return;
    }
}
