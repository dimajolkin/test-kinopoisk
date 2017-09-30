<?php

namespace app\service\kinopoisk\provider\site;

use app\service\kinopoisk\FilmInterface;
use app\service\kinopoisk\provider\ProviderInterface;

class SiteProvider implements ProviderInterface
{
    protected $page =  'http://www.kinopoisk.ru/top';


    /**
     * @param int $limit
     * @param \DateTime $time
     * @return iterable|FilmInterface[]
     */
    public function fetchTopByDate($limit = 10, \DateTime $time = null)
    {
        $parser = new Parser($this->page, $time);
        $list = [];
        foreach ($parser->getRecord() as $n => $record) {
            $list[] = $record;

            if ($n >= $limit) break;
        }

        return $list;
    }

    /**
     * @param \DateTime|null $time
     * @return FilmInterface[]|iterable
     */
    public function fetchAll(\DateTime $time = null): iterable
    {
        $parser = new Parser($this->page, $time);

        return $parser->getRecord();
    }

}