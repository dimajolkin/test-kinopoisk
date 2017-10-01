<?php

namespace app\actions;


use app\service\kinopoisk\KinopoiskService;
use app\service\kinopoisk\provider\DbProvider;
use app\service\kinopoisk\provider\ParserKinopoiskProvider;
use Doctrine\DBAL\Connection;
use Slim\Http\Request;
use Slim\Http\Response;

class ParserAction extends AbstractAction
{
    /**
     * Парсит данные и записывает их в базу
     *
     * @param Request $request
     * @param Response $response
     *
     */
    public function __invoke(Request $request, Response $response)
    {
        $service = new KinopoiskService(new ParserKinopoiskProvider());
        $filmCollection = $service->fetchAll(new \DateTime('now'));

        $connect = $this->container->get(Connection::class);

        $storage = new DbProvider($connect);
        $storage->insertAll($filmCollection);
    }
}