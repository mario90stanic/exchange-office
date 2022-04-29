<?php declare(strict_types=1);

namespace App\Currencies;

use App\Interfaces\CurrencyInterface;
use Exception;

class EUR extends CurrencyParent implements CurrencyInterface
{
    /**
     * @throws Exception
     */
    public function action(): float|int
    {
        $amount = $this->calculatedAmount + $this->calculatedAmount * $this->currency->surcharge / 100;

        return $amount - $amount * ($this->currency->discount / 100);
    }

    /**
     * @throws Exception
     */
    public function calculateWithSurcharge(): static
    {
        $this->calculateWithSurcharge = $this->action();

        return $this;
    }
}
