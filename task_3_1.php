<?php

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\Integration\DataConfig;
use src\Integration\DataProvider;

class DecoratorManager extends DataProvider
{
    public $cache;
    public $logger;

    /**
     * @param DataConfig $config
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(DataConfig $config, CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        parent::__construct($config);
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(array $input)
    {

        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);

            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
        } catch (Exception $e) {
            $this->logger->critical('Error getCache:' . $e->getMessage());
        }

        try {
            $result = parent::get($input);

            $cacheItem->set($result)->expiresAt((new DateTime())->modify('+1 day'));

            return $result;
        } catch (Exception $e) {
            $this->logger->critical('Error setCache:' . $e->getMessage());
        }

        return [];
    }

    /**
     * @param array $input
     * @return string
     */
    public function getCacheKey(array $input)
    {
        return json_encode($input);
    }
}
