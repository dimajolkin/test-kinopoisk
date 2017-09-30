<?php

namespace app;

use app\actions\MainAction;
use app\service\kinopoisk\KinopoiskService;
use Slim\App;
use Slim\Views\PhpRenderer;

class Application
{
    /** @var  App */
    protected $app;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->app = new App(include __DIR__ . '/config/config.php');

        $container = $this->app->getContainer();

        $container[KinopoiskService::class];
//        $container['logger'] = function($c) {
//            $logger = new \Monolog\Logger('my_logger');
//            $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
//            $logger->pushHandler($file_handler);
//            return $logger;
//        };


        $container['view'] = new PhpRenderer(__DIR__ . '/views');


        $this->app->get('/', new MainAction($container));
    }

    public function run()
    {
        $this->app->run();
    }
}