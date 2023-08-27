<?php

namespace App\Common\ValueObject;

use App\Common\Exception\ValidationException;

class Currency
{
    public function __construct(private readonly string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @throws ValidationException
     */
    public static function createFromString(string $value): self
    {
        if (false === preg_match('/^[A-Z]{3}$/', $value)) {
            throw new ValidationException(sprintf('Currency value is not valid. Got: \'%s\'.', $value));
        }

        return new self($value);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
