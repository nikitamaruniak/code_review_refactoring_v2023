<?php

namespace App\Infrastructure\Output;

use App\Common\Output\OutputInterface;

class OutputService implements OutputInterface
{
    public function echo(string $message): void
    {
        echo $message . "\n";
    }
}