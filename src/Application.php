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

    protected $actions = [
        '/' => MainAction::class,
    ];

    public function getSettingsConfig(): array
    {
        return include __DIR__ . '/config/web.settings.php';
    }

    public function getServicesConfig()
    {
        return include __DIR__ . '/config/services.config.php';
    }

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->app = new App(
            $this->getSettingsConfig() + $this->getServicesConfig()
        );
        $container = $this->app->getContainer();

//        $container['logger'] = function($c) {
//            $logger = new \Monolog\Logger('my_logger');
//            $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
//            $logger->pushHandler($file_handler);
//            return $logger;
//        };


//        $container['view'] = new PhpRenderer(__DIR__ . '/views');

        foreach ($this->actions as $route => $action) {
            $this->app->get($route, new $action($container));
        }
    }

    public function run()
    {
        $this->app->run();
    }
}