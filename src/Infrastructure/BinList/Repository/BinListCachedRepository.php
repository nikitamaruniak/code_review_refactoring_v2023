<?php

namespace App\Infrastructure\BinList\Repository;

use App\BinList\Repository\BinListRepositoryInterface;
use App\Infrastructure\BinList\Exception\BinListRepositoryException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class BinListCachedRepository implements BinListRepositoryInterface
{
    private const CACHE_KEY = 'bin';
    private const CACHE_TTL = 60 * 60 * 24 * 30;

    private readonly FilesystemAdapter $cache;

    public function __construct()
    {
        $this->cache = new FilesystemAdapter();
    }

    public function getBinLookUp(int $bin)
    {
        return $this->getFromCache($bin);
    }

    private function getFromCache(int $bin)
    {
        $key = self::CACHE_KEY . $bin;

        try {
            return $this->cache->get($key, function (ItemInterface $item) use ($bin): array {
                $item->expiresAfter(self::CACHE_TTL);

                return $this->get($bin);
            });
        } catch (InvalidArgumentException $exception) {
            throw new BinListRepositoryException(sprintf('Cache failed. Reason: \'%s\'', $exception->getMessage()));
        }
    }

    private function get(int $bin)
    {
        $url = sprintf('https://lookup.binlist.net/%d', $bin);
        $rawData = file_get_contents($url);
        if (false === $rawData) {
            throw new BinListRepositoryException(sprintf('Failed get request from url \'%s\'', $url));
        }

        return json_decode($rawData, true);
    }
}