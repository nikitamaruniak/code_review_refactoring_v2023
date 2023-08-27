<?php

namespace App\BinList\ValueObject;

use App\Common\ValueObject\Country;

class BinLookUp
{
    private function __construct(private readonly array $values)
    {
    }

    public static function createFromArray(array $values): self
    {
        return new self($values);
    }

    public function getCountry(): Country
    {
        return Country::createFromAlpha2($this->values['country']['alpha2']);
    }
}
