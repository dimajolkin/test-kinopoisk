<?php

namespace app\actions;

use app\service\kinopoisk\KinopoiskService;
use DateTime;
use Slim\Http\Request;
use Slim\Http\Response;

class MainAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response)
    {
        $date = DateTime::createFromFormat('Y-m-d', $request->getParam('date', null)) ?: new DateTime('now');

        $films = $this->container->get(KinopoiskService::class)->fetchTopByDate(9, $date);

        return $this->render->render($response, 'index.phtml', [
            'films' => $films
        ]);
    }
}