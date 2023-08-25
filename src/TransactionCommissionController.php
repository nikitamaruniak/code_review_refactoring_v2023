<?php

namespace App;

use App\Exception\InputDataValidationException;
use App\ValueObject\Input;
use App\ValueObject\TransactionData;

class TransactionCommissionController
{
    public static function run(Input $input): void
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

            // calculate commission
        }
    }
}