<?php

namespace app\service\kinopoisk;

use app\service\kinopoisk\provider\ProviderInterface;
use app\service\kinopoisk\provider\site\SiteProvider;

class KinopoiskService
{
    /** @var  ProviderInterface */
    protected $provider;

    public function __construct()
    {
        $this->provider = new SiteProvider();
    }

    /**
     * @param int $limit
     * @param \DateTime $time
     * @return iterable|FilmInterface[]
     */
    public function fetchTopByDate($limit = 10, \DateTime $time = null): iterable
    {
        return $this->provider->fetchTopByDate($limit, $time);
    }
}