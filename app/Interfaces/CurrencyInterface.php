<?php declare(strict_types=1);

namespace App\Interfaces;

interface CurrencyInterface
{
    public function calculate();
    public function getCurrency();
    public function calculateWithSurcharge();
    public function action();
}
