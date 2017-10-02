<?php

namespace app\actions;


use app\service\kinopoisk\KinopoiskService;
use app\service\kinopoisk\provider\DbProvider;
use app\service\kinopoisk\provider\ParserKinopoiskProvider;
use DateTime;
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
        $date = DateTime::createFromFormat('Y-m-d', $request->getParam('date', null)) ?: new DateTime('now');

        $service = new KinopoiskService(new ParserKinopoiskProvider());
        $filmCollection = $service->fetchAll($date);

        $connect = $this->container->get(Connection::class);

        $storage = new DbProvider($connect);
        $storage->insertAll($filmCollection);
    }
}