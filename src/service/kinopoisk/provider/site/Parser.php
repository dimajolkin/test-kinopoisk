<?php

namespace app\service\kinopoisk\provider\site;

use DateTime;
use Sunra\PhpSimple\HtmlDomParser;

class Parser
{
    protected $url = '';

    /**
     * Parser constructor.
     * @param string $url
     * @param DateTime $dateTime
     */
    public function __construct(string $url, DateTime $dateTime = null)
    {
        if ($dateTime) {
            $this->url = $url .  '/day/' . $dateTime->format('Y-m-d');
        } else {
            $this->url = $url;
        }
    }

    public function getRecord(): iterable
    {
        $html = file_get_contents($this->url);

        $dom = HtmlDomParser::str_get_html($html);

        foreach ($dom->find('table > table > table > table tr') as $n => $tr) {
            if ($n === 0) continue;

            $arrayTdValues = [];
            foreach ($tr->find('td') as $k => $td) {
                switch ($k) {
                    case 0:
                        $arrayTdValues[$k] = $td->text();
                        break;
                    case 1:
                        $rusName = $td->find('a', 0)->text();
                        list($year, $name) = $this->parseYearAndName($rusName);

                        $originalName = null;
                        if ($span = $td->find('span', 0)) {
                            $originalName = $span->text();
                        } else {
                            //rus film
                            $originalName = iconv('windows-1251', 'utf-8', $name);
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

        return new Film(
            $position,
            $rating,
            $name,
            $year,
            $count,
            (new DateTime('now'))
        );
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