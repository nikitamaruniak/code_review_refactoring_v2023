<?php

namespace App\Presentation\Controller;

use App\ExchangeRate\ExchangeRateService;
use App\Presentation\ValueObject\Input;
use App\Presentation\ValueObject\TransactionData;
use App\TransactionCommission\Exception\InputDataValidationException;

class TransactionCommissionController
{
    public function __construct(private readonly ExchangeRateService $exchangeRateService)
    {
    }

    public function run(Input $input): void
    {
        $inputFileName = $input->getInputFileName();

        if (null === $inputFileName) {
            echo "Please provide file with input data.\n";

            return;
        }

        foreach (explode("\n", file_get_contents($inputFileName)) as $row) {
            $row = trim($row);

            if (empty($row)) {
                continue;
            }

            try {
                $transactionData = TransactionData::createFromString($row);
                var_dump($transactionData);
            } catch (InputDataValidationException $exception) {
                // TODO: log
                throw $exception;
            }

            // get $amount in EUR
//            $amountEur = $transactionData->getAmount() / $this->exchangeRateService->getEurRateByCurrency($transactionData->getCurrency());

            // calculate commission
        }
    }
}