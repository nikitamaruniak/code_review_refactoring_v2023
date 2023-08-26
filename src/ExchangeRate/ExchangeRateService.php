<?php

namespace App\ExchangeRate;

use App\ExchangeRate\Repository\ExchangeRateRepositoryInterface;
use App\ExchangeRate\Exeption\ExchangeRateRepositoryException;

readonly class ExchangeRateService
{
    public function __construct(private readonly ExchangeRateRepositoryInterface $repository)
    {
    }

    /**
     * @throws ExchangeRateRepositoryException
     */
    public function getEurRateByCurrency(string $currency): string
    {
        return $this->repository->getEurRateByCurrency($currency);
    }
}
