<?php

namespace App\Presentation\ValueObject;

use App\TransactionCommission\Exception\InputDataValidationException;

class TransactionData
{
    public function __construct(
        private readonly int $bin,
        private readonly float $amount,
        private readonly string $currency,
    ) {
    }

    public function getBin(): int
    {
        return $this->bin;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public static function createFromString(string $inputData): self
    {
        $data = json_decode($inputData, true, 2);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InputDataValidationException(sprintf('Not valid json string: \'s\'.', $inputData));
        }

        $errors = [];
        if (false === empty($data['bin']) && preg_match('/^[\d]+$/', $data['bin'])) {
            $bin = (int) $data['bin'];
        } else {
            $errors[] = 'bin';
        }

        if (false === empty($data['amount']) && preg_match('/^[0-9]*\.[0-9]{2}$/', $data['amount'])) {
            $amount = (int) $data['amount'];
        } else {
            $errors[] = 'amount';
        }

        if (false === empty($data['currency']) && preg_match('/^[A-Z]{3}$/', $data['currency'])) {
            $currency = $data['currency'];
        } else {
            $errors[] = 'currency';
        }

        if (false === empty($errors)) {
            throw new InputDataValidationException(sprintf(
                'Not valid json string: \'%s\'. Suspicious values: \'%s\'.',
                $inputData,
                implode(',', $errors),
            ));
        }

        return new self($bin, $amount, $currency);
    }
}