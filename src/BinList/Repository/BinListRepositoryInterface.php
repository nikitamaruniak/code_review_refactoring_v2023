<?php

namespace App\BinList\Repository;

use App\BinList\ValueObject\BinLookUp;
use App\Common\ValueObject\Bin;

interface BinListRepositoryInterface
{
    # CR: YAGNI: Оскільки нас цікавить тільки країна, то інтерфейс можна скоротити до `getCountry(Bin $bin): Country`.
    public function getBinLookUp(Bin $bin): BinLookUp;
}