<?php

namespace App\Common\ValueObject;

use App\Common\Exception\ValidationException;

class Bin
{
    public function __construct(private readonly int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @throws ValidationException
     */
    public static function createFromString(string $value): self
    {
        if (false === preg_match('/^[\d]+$/', $value)) {
            throw new ValidationException(sprintf('Bin value is not valid. Got: \'%s\'.', $value));
        }

        return new self((int) $value);
    }
}
