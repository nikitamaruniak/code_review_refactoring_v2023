<?php

namespace App\Presentation\Controller;

use App\BinList\BinListService;
use App\ExchangeRate\ExchangeRateService;
use App\Presentation\ValueObject\Input;
use App\Presentation\ValueObject\TransactionData;
use Throwable;

class TransactionCommissionController
{
    public function __construct(
        private readonly ExchangeRateService $exchangeRateService,
    ) {
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
                $rate = $this->exchangeRateService->getEurRateByCurrency($transactionData->getCurrency());
                $amountEur = $transactionData->getAmount() / $rate;

                // calculate commission

                var_dump('rate: ' . $rate);
                var_dump('getAmount: ' . $transactionData->getAmount());
                var_dump('amountEur: ' . $amountEur);
//                var_dump($transactionData);
            } catch (Throwable $exception) {
                // TODO: log
                throw $exception;

                continue;
            }
        }
    }
}
