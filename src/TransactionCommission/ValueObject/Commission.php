<?php

namespace App\TransactionCommission\ValueObject;

use App\Common\ValueObject\Amount;

class Commission
{
    private function __construct(private readonly Amount $amount)
    {
    }

    public static function create(Amount $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return round($this->amount->getValue(), 2);
    }
}
