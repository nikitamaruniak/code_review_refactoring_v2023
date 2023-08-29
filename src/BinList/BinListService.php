<?php

namespace App\BinList;

use App\BinList\Repository\BinListRepositoryInterface;
use App\BinList\ValueObject\BinLookUp;
use App\Common\ValueObject\Bin;

class BinListService
{
    public function __construct(private readonly BinListRepositoryInterface $repository)
    {
    }

    public function getBinLookUp(Bin $bin): BinLookUp
    {
        # CR: YAGNI: Визначення BinListService повністю повторює визначення BinListRepositoryInterface то ж перший можна видалити.
        return $this->repository->getBinLookUp($bin);
    }
}