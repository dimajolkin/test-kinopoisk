<?php

namespace app\service\kinopoisk\components;

use app\service\kinopoisk\film\FilmBuilder;
use DateTime;
use Sunra\PhpSimple\HtmlDomParser;

class ParserKinopoisk
{
    protected $url = '';

    /**
     * @var DateTime
     */
    private $dateTime;

    const ENCODING = 'windows-1251';

    /**
     * Parser constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getRecordByDate(DateTime $dateTime = null): iterable
    {
        if ($dateTime) {
            $this->url = $this->url .  '/day/' . $dateTime->format('Y-m-d');
        }

        $html = file_get_contents($this->url);

        if (!$dom = HtmlDomParser::str_get_html($html)) {
            return [];
        }

        $table = $dom->find('table > table > table > table tr');
        if (!$table) {
            return [];
        }

        foreach ($table as $n => $tr) {
            if ($n === 0) continue;

            $arrayTdValues = [];
            foreach ($tr->find('td') as $k => $td) {
                switch ($k) {
                    case 0:
                        $arrayTdValues[$k] = $td->text();
                        break;
                    case 1:
                        $rusName = $td->find('a', 0)->text();
                        [$year, $name] = $this->parseYearAndName($rusName);

                        $originalName = null;
                        if ($span = $td->find('span', 0)) {
                            $originalName = $span->text();
                        } else {
                            //rus film
                            $originalName = iconv(static::ENCODING, 'utf-8', $name);
                        }

                        $arrayTdValues[$k] = [$year, $originalName];
                        break;
                    case 2:
                        $arrayTdValues[$k] = $td->text();
                        break;
                }

            }

            yield $this->buildFilm($arrayTdValues);
        }
    }

    private function parsePosition($string): int
    {
        return (int)str_replace('.', '', $string);
    }

    protected function buildFilm(array $data)
    {
        $position = $this->parsePosition($data[0]);
        [$rating, $count] = $this->parseRatingAndCount($data[2]);
        [$year, $name] = $this->parseYearAndName($data[1]);

        return (new FilmBuilder())
            ->setPosition($position)
            ->setRating($rating)
            ->setNumberVoted($count)
            ->setYear($year)
            ->setName($name)
            ->setDate($this->dateTime ?: new DateTime('now'))
            ->create();
    }

    private function parseRatingAndCount($string): array
    {
        $match = [];
        preg_match('/(?<rating>.*) \((?<count>.*)\)/', $string,  $match);
        $count = preg_replace('/[^0-9]/', '', $match['count']);

        return [
            floatval($match['rating']),
            intval($count)
        ];
    }

    private function parseYearAndName($string): array
    {
        if (is_array($string)) {
            return $string;
        }

        $match = [];
        preg_match('/(?<name>.*)\((?<year>.*)\)/', $string,  $match);

        $name = trim(ltrim($match['name']));

        return [
            intval($match['year']),
            $name
        ];
    }
}