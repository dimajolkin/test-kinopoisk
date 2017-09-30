<?php

namespace app\service\kinopoisk\provider;


use app\service\kinopoisk\FilmInterface;

interface ProviderInterface
{
    /**
     * @param int $limit
     * @param \DateTime $time
     * @return iterable|FilmInterface[]
     */
    public function fetchTopByDate($limit = 10, \DateTime $time = null);

    /**
     * @param \DateTime|null $time
     * @return FilmInterface[]|iterable
     */
    public function fetchAll(\DateTime $time = null): iterable;
}