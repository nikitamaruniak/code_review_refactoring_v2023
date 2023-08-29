<?php

namespace App\Common\Output;

# CR: Яке призначення простору імен Common, чому OutputInterface знаходиться в ньому, а TransactionCommissionController - ні?
interface OutputInterface
{
    public function echo(string $message): void;
}
