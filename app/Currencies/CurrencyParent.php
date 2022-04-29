<?php declare(strict_types=1);

namespace App\Currencies;

use App\Models\Order;
use App\Models\Currency;
use Exception;

abstract class CurrencyParent
{
    protected object $currency;
    protected float $amount;
    protected float $calculatedAmount = 0;
    protected float $calculateWithSurcharge = 0;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @throws Exception
     */
    public function setUp(): static
    {
        $this->setCurrency()
            ->calculate()
            ->calculateWithSurcharge();

        return $this;
    }

    /**
     * @throws Exception
     */
    public function calculate(): static
    {
        $this->calculatedAmount = $this->amount / $this->currency->rate;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function setCurrency(): static
    {
        $className = (new \ReflectionClass($this))->getShortName();
        $this->currency = Currency::where('name', $className)->firstOrFail();

        return $this;
    }

    /**
     * @throws Exception
     */
    public function calculateWithSurcharge(): static
    {
        $this->calculateWithSurcharge = $this->calculatedAmount + $this->calculatedAmount * $this->currency->surcharge / 100;

        return $this;
    }

    public function makeOrder()
    {
        return Order::make($this);
    }

    public function getCurrency(): object
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCalculatedAmount(): float
    {
        return $this->calculatedAmount;
    }

    public function getCalculatedWithSurcharge(): float
    {
        return $this->calculateWithSurcharge;
    }

    public function getDiscountAmount(): float
    {
        return $this->getCalculatedAmount() * $this->getCurrency()->discount / 100;
    }

    public function getSurchargeAmount(): float
    {
        return $this->getAmount() * $this->getCurrency()->surcharge / 100;
    }
}
