<?php

namespace app\tests\unit;


use app\service\kinopoisk\FilmInterface;

use app\service\kinopoisk\provider\site\SiteProvider;
use app\tests\TestCase;

class SiteProviderTest extends TestCase
{
    public function testParse()
    {
        $provider = new SiteProvider();
        list(,,,,,,,,,$first) = $provider->fetchTopByDate(10);

        $this->assertInstanceOf(FilmInterface::class, $first);
    }

}