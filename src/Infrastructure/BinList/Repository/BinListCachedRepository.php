<?php

namespace App\Infrastructure\BinList\Repository;

use App\BinList\Repository\BinListRepositoryInterface;
use App\BinList\ValueObject\BinLookUp;
use App\Common\ValueObject\Bin;
use App\ExchangeRate\Exeption\ExchangeRateRepositoryException;
use App\Infrastructure\BinList\Exception\BinListRepositoryException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class BinListCachedRepository implements BinListRepositoryInterface
{
    private const CACHE_KEY = 'bin12';
    private const CACHE_TTL = 60 * 60 * 24 * 30;

    private readonly FilesystemAdapter $cache;

    public function __construct()
    {
        $this->cache = new FilesystemAdapter();
    }

    public function getBinLookUp(Bin $bin): BinLookUp
    {
        return $this->getFromCache($bin);
    }

    private function getFromCache(Bin $bin): BinLookUp
    {
        $key = self::CACHE_KEY . $bin->getValue();

        try {
            $value =  $this->cache->get($key, function (ItemInterface $item) use ($bin): BinLookUp {
                $item->expiresAfter(self::CACHE_TTL);

                return $this->get($bin);
            });
        } catch (InvalidArgumentException $exception) {
            # CR: Fail Fast: InvalidArgumentException схоже на помилку програміста тому нема сенсу його очікувати.
            throw new BinListRepositoryException(sprintf('Cache failed. Reason: \'%s\'', $exception->getMessage()));
        }

        return $value;
    }

    private function get(Bin $bin): BinLookUp
    {
        $url = sprintf('https://lookup.binlist.net/%d', $bin->getValue());
        $rawData = file_get_contents($url);
        if (false === $rawData) {
            throw new BinListRepositoryException(sprintf('Failed get request from url \'%s\'', $url));
        }

        $data = @json_decode($rawData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            # CR: Помарка, має бути BinListRepositoryException.
            throw new ExchangeRateRepositoryException(sprintf('Failed decode response data: \'%s\'. Error: \'%s\'', $rawData, json_last_error()));
        }

        return BinLookUp::createFromArray($data);
    }
}