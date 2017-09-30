<?php

namespace app\actions;

use app\service\kinopoisk\KinopoiskService;
use DateTime;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class MainAction
{
    /** @var  ContainerInterface */
    protected $container;

    /**
     * MainAction constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response)
    {
        $date = DateTime::createFromFormat('Y-m-d', $request->getParam('date', null)) ?: new DateTime('now');

        $films = $this->container->get(KinopoiskService::class)->fetchTopByDate(9, $date);

        return $this->container->get('view')->render($response, 'index.phtml', [
            'films' => $films
        ]);
    }
}