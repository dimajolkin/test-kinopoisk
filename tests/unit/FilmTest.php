<?php

namespace unit;

use app\service\kinopoisk\film\FilmBuilder;
use app\service\kinopoisk\FilmInterface;
use app\tests\TestCase;

class FilmTest extends TestCase
{
    /**
     * @dataProvider providerArrayForBuildFilm
     * @param $array
     */
    public function testCreateByArray($array)
    {
        $film = (new FilmBuilder($array))->create();

        static::assertInstanceOf(FilmInterface::class, $film);
    }

    public function providerArrayForBuildFilm()
    {
        return [
            [
                [
                    'position' => 1,
                    'rating' => 1,
                    'name' => 'name',
                    'year' => 1,
                    'numberVoted' => 1,
                    'date' => new \DateTime('now'),
                ]
            ],
        ];
    }

}