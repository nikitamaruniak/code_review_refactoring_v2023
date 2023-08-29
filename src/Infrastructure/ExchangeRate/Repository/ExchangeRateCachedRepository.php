<?php

namespace App\Infrastructure\ExchangeRate\Repository;

use App\Common\ValueObject\Currency;
use App\ExchangeRate\Exeption\ExchangeRateRepositoryException;
use App\ExchangeRate\Repository\ExchangeRateRepositoryInterface;
use App\ExchangeRate\ValueObject\ExchangeRate;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class ExchangeRateCachedRepository implements ExchangeRateRepositoryInterface
{
    private const CACHE_KEY = 'rates';
    private const CACHE_TTL = 60 * 60;

    private readonly FilesystemAdapter $cache;

    public function __construct()
    {
        $this->cache = new FilesystemAdapter();
    }

    /**
     * @throws ExchangeRateRepositoryException
     */
    public function getByCurrency(Currency $currency, Currency $baseCurrency): ExchangeRate
    {
        $rates = $this->getFromCache();

        if (false === isset($rates[$currency->getValue()])) {
            throw new ExchangeRateRepositoryException(sprintf('Not found rate by currency \'%s\'.', $currency));
        }

        return new ExchangeRate($rates[$currency->getValue()], $currency, $baseCurrency);
    }

    private function getFromCache(): array
    {
        try {
            return $this->cache->get(self::CACHE_KEY, function (ItemInterface $item): array {
                $item->expiresAfter(self::CACHE_TTL);

                return $this->get();
            });

        } catch (InvalidArgumentException $exception) {
            # CR: Fail Fast: InvalidArgumentException схоже на помилку програміста тому нема сенсу його очікувати.
            throw new ExchangeRateRepositoryException(sprintf('Cache failed. Reason: \'%s\'', $exception->getMessage()));
        }
    }

    /**
     * @throws ExchangeRateRepositoryException
     */
    private function get(): array
    {
        // TODO: key to ENV
        $url = 'http://api.exchangeratesapi.io/latest?access_key=082f5bc4ea088232d29c613e0aa2b6ee';
        $rawData = file_get_contents($url);
        if (false === $rawData) {
            throw new ExchangeRateRepositoryException(sprintf('Failed get request from url \'%s\'', $url));
        }

        $data = @json_decode($rawData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ExchangeRateRepositoryException(sprintf('Failed decode response data: \'%s\'. Error: \'%s\'', $rawData, json_last_error()));
        }

        if (empty($data['rates'])) {
            throw new ExchangeRateRepositoryException(sprintf('Not found rates in response data: \'%s\'', $rawData));
        }

        return $data['rates'];
    }
}
