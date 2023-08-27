<?php

namespace App\Common\ValueObject;

class Country
{
    private const EU_COUNTRIES = ['AT','BE','BG','CY','CZ','DE','DK','EE','ES','FI','FR','GR','HR','HU','IE','IT','LT','LU','LV','MT','NL','PO','PT','RO','SE','SI','SK',];

    public function __construct(private readonly string $alpha2)
    {
    }

    public static function createFromAlpha2(string $alpha2): self
    {
        return new self($alpha2);
    }
    
    public function isEu(): bool
    {
        return in_array($this->alpha2, self::EU_COUNTRIES);
    }
}
