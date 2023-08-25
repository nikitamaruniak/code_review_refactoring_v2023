<?php

namespace App\ValueObject;

class Input
{
    public function __construct(
        private readonly array $argv,
    ) {
    }

    public static function createFromArgv(array $argv): self
    {
        return new Input($argv);
    }

    public function getInputFileName(): ?string
    {
        return $this->argv[1] ?? null;
    }
}
