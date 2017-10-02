<?php

namespace app;

use app\actions\ParserAction;
use Slim\Http\Environment;

class ConsoleApplication extends Application
{
    protected $actions = [
        '/' => ParserAction::class,
    ];

    /**
     * ConsoleApplication constructor.
     * @param $argv
     */
    public function __construct($argv)
    {
        parent::__construct();
        array_shift($argv);

        $env = Environment::mock([
            'QUERY_STRING' => implode('&', $argv),
            ]);

        $container = $this->app->getContainer();
        $container['environment'] = $env;
    }

    public function getSettingsConfig(): array
    {
        return include __DIR__ . '/config/console.settings.php';
    }
}