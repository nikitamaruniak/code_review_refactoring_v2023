<?php

namespace App\BinList\Repository;

use App\BinList\ValueObject\BinLookUp;
use App\Common\ValueObject\Bin;

interface BinListRepositoryInterface
{
    public function getBinLookUp(Bin $bin): BinLookUp;
}