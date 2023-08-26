<?php

namespace App\BinList\Repository;

interface BinListRepositoryInterface
{
    public function getBinLookUp(int $bin);
}