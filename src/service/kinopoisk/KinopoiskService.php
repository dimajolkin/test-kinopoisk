<?php

namespace app\service\kinopoisk;

use app\service\kinopoisk\provider\ProviderInterface;
use app\service\kinopoisk\provider\ParserKinopoiskProvider;

class KinopoiskService
{
    /** @var  ProviderInterface */
    protected $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param int $limit
     * @param \DateTime $time
     * @return FilmCollection|FilmInterface[]
     */
    public function fetchTopByDate($limit = 10, \DateTime $time = null): FilmCollection
    {
        return $this->provider->fetchTopByDate($limit, $time);
    }

    /**
     * @param \DateTime|null $time
     * @return FilmInterface[]|FilmCollection
     */
    public function fetchAll(\DateTime $time = null): FilmCollection
    {
        return $this->provider->fetchAll($time);
    }
}