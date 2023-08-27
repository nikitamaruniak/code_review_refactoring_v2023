<?php

namespace App\ExchangeRate\ValueObject;

use App\Common\ValueObject\Currency;

class ExchangeRate
{
    public function __construct(
        private readonly float $value,
        private readonly Currency $currency,
        private readonly Currency $baseCurrency,
    ) {
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getBaseCurrency(): Currency
    {
        return $this->baseCurrency;
    }
}
