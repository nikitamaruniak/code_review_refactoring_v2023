<?php

namespace App\BinList;

use App\BinList\Repository\BinListRepositoryInterface;

class BinListService
{
    public function __construct(private readonly BinListRepositoryInterface $repository)
    {
    }

    public function getBinLookUp(int $bin)
    {
        return $this->repository->getBinLookUp($bin);
    }
}