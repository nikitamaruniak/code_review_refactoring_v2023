<?php

namespace App\ExchangeRate;

use App\Common\ValueObject\Currency;
use App\ExchangeRate\Repository\ExchangeRateRepositoryInterface;
use App\ExchangeRate\Exeption\ExchangeRateRepositoryException;
use App\ExchangeRate\ValueObject\ExchangeRate;

readonly class ExchangeRateService
{
    public function __construct(private readonly ExchangeRateRepositoryInterface $repository)
    {
    }

    /**
     * @throws ExchangeRateRepositoryException
     */
    public function getByCurrency(Currency $currency, Currency $baseCurrency): ExchangeRate
    {
        return $this->repository->getByCurrency($currency, $baseCurrency);
    }
}
