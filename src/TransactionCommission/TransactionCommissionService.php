<?php

namespace App\TransactionCommission;

use App\BinList\BinListService;
use App\Presentation\ValueObject\TransactionData;

class TransactionCommissionService
{
    public function __construct(
        private readonly BinListService $binListService,
    ) {
    }

    public function calculateCommission(TransactionData $transactionData): float
    {
        $binLookUp = $this->binListService->getBinLookUp($transactionData->getBin());

//        return $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);

    }
}
