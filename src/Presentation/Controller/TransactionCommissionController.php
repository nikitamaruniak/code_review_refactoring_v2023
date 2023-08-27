<?php

namespace App\Presentation\Controller;

use App\Common\Output\OutputInterface;
use App\Common\ValueObject\TransactionData;
use App\Presentation\ValueObject\Input;
use App\TransactionCommission\TransactionCommissionService;
use Throwable;

readonly class TransactionCommissionController
{
    public function __construct(
        private readonly TransactionCommissionService $transactionCommissionService,
        private readonly OutputInterface $output,
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
                $commission = $this->transactionCommissionService->calculateCommission(
                    TransactionData::createFromString($row)
                );

                $this->output->echo($commission);
            } catch (Throwable $exception) {
                // TODO: log
                throw $exception;

                continue;
            }
        }
    }
}
