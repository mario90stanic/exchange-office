<?php declare(strict_types=1);

namespace App\Interfaces;

interface FactoryInterface
{
    public static function make(float $amount, string $name);
}
