<?php

namespace App\Common\ValueObject;

use App\Common\Exception\ValidationException;

class TransactionData
{
    public function __construct(
        private readonly Bin $bin,
        private readonly Amount $amount,
        private readonly Currency $currency,
    ) {
    }

    public function getBin(): Bin
    {
        return $this->bin;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @throws ValidationException
     */
    # CR: Краще назвати цей метод createFromJSON або createFromJSONString заради прозорості імені.
    # CR: Чому б відповідальність за відкриття на парсинг вхідного файла не віддати окремому сервісу?
    public static function createFromString(string $inputData): self
    {
        $data = json_decode($inputData, true, 2);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ValidationException(sprintf('Not valid json string: \'%s\'.', $inputData));
        }

        $errors = [];

        try {
            $bin = Bin::createFromString($data['bin'] ?? '');
        } catch (ValidationException $exception) {
            $errors[] = $exception->getMessage();
        }

        try {
            $amount = Amount::createFromString($data['amount'] ?? '');
        } catch (ValidationException $exception) {
            $errors[] = $exception->getMessage();
        }

        try {
            $currency = Currency::createFromString($data['currency'] ?? '');
        } catch (ValidationException $exception) {
            $errors[] = $exception->getMessage();
        }

        if (false === empty($errors)) {
            throw new ValidationException(sprintf(
                'Not valid json string: \'%s\'. Errors: \'%s\'.',
                $inputData,
                implode(' ', $errors),
            ));
        }

        return new self($bin, $amount, $currency);
    }
}
