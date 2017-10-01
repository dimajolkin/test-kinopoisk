<?php

namespace app\service\kinopoisk\provider;


use app\service\kinopoisk\FilmCollection;
use app\service\kinopoisk\FilmInterface;
use DateTime;

interface ProviderInterface
{
    /**
     * @param int $limit
     * @param DateTime $time
     * @return FilmCollection|FilmInterface[]
     */
    public function fetchTopByDate($limit = 10, DateTime $time = null): FilmCollection;

    /**
     * @param DateTime|null $time
     * @return FilmCollection|FilmInterface[]
     */
    public function fetchAll(DateTime $time = null): FilmCollection;
}