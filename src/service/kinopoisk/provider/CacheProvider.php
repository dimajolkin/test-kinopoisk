<?php

namespace app\service\kinopoisk\provider;

use app\service\kinopoisk\film\FilmBuilder;
use app\service\kinopoisk\FilmCollection;
use app\storage\StorageInterface;
use DateTime;
use Redis;

class CacheProvider implements ProviderInterface
{
    /** @var  ProviderInterface */
    protected $baseProvider;
    /**
     * @var StorageInterface
     */
    private $storage;
    /**
     * @var int
     */
    private $ttl;


    /**
     * CacheProvider constructor.
     * @param ProviderInterface $baseProvider
     * @param StorageInterface $storage
     * @param int $ttl
     */
    public function __construct(
        ProviderInterface $baseProvider,
        StorageInterface $storage,
        ?int $ttl = null
    )
    {
        $this->baseProvider = $baseProvider;
        $this->storage = $storage;
        $this->ttl = $ttl;
    }

    private function buildKey(DateTime $time, $limit): string
    {
        return 'limit:'. $limit .':date:'. $time->format('Y-m-d');
    }

    public function fetchTopByDate($limit = 10, DateTime $time = null): FilmCollection
    {
        $time = $time ?: new DateTime('now');

        $key = $this->buildKey($time, $limit);
        if (!$this->storage->has($key)) {
            $films = $this->baseProvider->fetchTopByDate($limit, $time);

            $array = $films->toArray();
            if ($array) {
                $this->storage->set($key, json_encode($array), $this->ttl);
            }

            return $films;
        }

        $collection = new FilmCollection([]);
        foreach (json_decode($this->storage->get($key), true) as $value) {
            $collection->add((new FilmBuilder($value))->create());
        }

        return $collection;
    }

    public function fetchAll(DateTime $time = null): FilmCollection
    {
        return $this->baseProvider->fetchAll($time);
    }
}