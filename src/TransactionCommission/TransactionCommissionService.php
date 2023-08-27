<?php

namespace App\TransactionCommission;

use App\BinList\BinListService;
use App\Common\ValueObject\Country;
use App\Common\ValueObject\Currency;
use App\Common\ValueObject\TransactionData;
use App\ExchangeRate\ExchangeRateService;
use App\TransactionCommission\ValueObject\Commission;

class TransactionCommissionService
{
    private const COMMISSION_COEFF_EU = 0.01;
    private const COMMISSION_COEFF_NON_EU = 0.02;

    public function __construct(
        private readonly ExchangeRateService $exchangeRateService,
        private readonly BinListService $binListService,
    ) {
    }

    public function calculateCommission(TransactionData $transactionData): Commission
    {
        $rate = $this->exchangeRateService->getByCurrency(
            $transactionData->getCurrency(),
            Currency::createFromString('EUR')
        );
        $amount = $transactionData->getAmount()->divide($rate->getValue());
        $binLookUp = $this->binListService->getBinLookUp($transactionData->getBin());

        return Commission::create(
            $amount->multiply($this->getCommissionCoeff($binLookUp->getCountry()))
        );
    }

    private function getCommissionCoeff(Country $country): float
    {
        return $country->isEu() ? self::COMMISSION_COEFF_EU : self::COMMISSION_COEFF_NON_EU;
    }
}
