<?php

namespace App;

use App\Exception\InputDataValidationException;
use App\ValueObject\InputDataVO;

class TransactionCommissionController
{
    public static function run(string $inputData): void
    {
        foreach (explode("\n", file_get_contents($inputData)) as $row) {
            $row = trim($row);

            if (empty($row)) {
                continue;
            }

            try {
                $inputData = InputDataVO::createFromString($row);
//                var_dump($inputData);
            } catch (InputDataValidationException $exception) {
                // TODO: log
                throw $exception;
            }

            // get $amount in EUR

            // calculate commission
        }
    }
}