<?php

namespace app\service\kinopoisk\provider;

use app\service\kinopoisk\components\ParserKinopoisk;
use app\service\kinopoisk\FilmCollection;
use app\service\kinopoisk\FilmInterface;
use DateTime;

class ParserKinopoiskProvider implements ProviderInterface
{
    protected $page =  'http://www.kinopoisk.ru/top';

    /** @var  ParserKinopoisk */
    private $parser;

    /**
     * ParserKinopoiskProvider constructor.
     */
    public function __construct()
    {
        $this->parser = new ParserKinopoisk($this->page);
    }


    /**
     * @param int $limit
     * @param DateTime $time
     * @return FilmCollection|FilmInterface[]
     */
    public function fetchTopByDate($limit = 10, DateTime $time = null): FilmCollection
    {
        $list = [];
        foreach ($this->parser->getRecordByDate($time) as $n => $record) {
            $list[] = $record;

            if ($n >= $limit) break;
        }

        return new FilmCollection($list);
    }

    /**
     * @param DateTime|null $time
     * @return FilmInterface[]|FilmCollection
     */
    public function fetchAll(DateTime $time = null): FilmCollection
    {
        return new FilmCollection($this->parser->getRecordByDate($time));
    }
}