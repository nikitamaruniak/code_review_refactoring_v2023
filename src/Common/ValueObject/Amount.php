<?php

namespace App\Common\ValueObject;

use App\Common\Exception\ValidationException;

class Amount
{
    public function __construct(private readonly float $value)
    {
    }

    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @throws ValidationException
     */
    public static function createFromString(string $value): self
    {
        if (false === preg_match('/^[0-9]*\.[0-9]{2}$/', $value)) {
            throw new ValidationException(sprintf('Amount value is not valid. Got: \'%s\'.', $value));
        }

        return new self((float) $value);
    }

    public function divide(float $divider): self
    {
        return new self($this->value / $divider);
    }

    public function multiply(float $multiplier): self
    {
        return new self($this->value * $multiplier);
    }
}
