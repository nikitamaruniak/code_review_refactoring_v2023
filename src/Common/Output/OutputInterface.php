<?php

namespace App\Common\Output;

interface OutputInterface
{
    public function echo(string $message): void;
}
