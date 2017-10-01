<?php

namespace app\service\kinopoisk\provider;

use app\service\kinopoisk\FilmCollection;
use app\service\kinopoisk\FilmInterface;

class ParserKinopoiskProvider implements ProviderInterface
{
    protected $page =  'http://www.kinopoisk.ru/top';


    /**
     * @param int $limit
     * @param \DateTime $time
     * @return FilmCollection|FilmInterface[]
     */
    public function fetchTopByDate($limit = 10, \DateTime $time = null): FilmCollection
    {
        $parser = new Parser($this->page, $time);
        $list = [];
        foreach ($parser->getRecord() as $n => $record) {
            $list[] = $record;

            if ($n >= $limit) break;
        }

        return new FilmCollection($list);
    }

    /**
     * @param \DateTime|null $time
     * @return FilmInterface[]|FilmCollection
     */
    public function fetchAll(\DateTime $time = null): FilmCollection
    {
        $parser = new Parser($this->page, $time);

        return new FilmCollection($parser->getRecord());
    }
}