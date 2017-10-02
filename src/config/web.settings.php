<?php

return [
    'settings' => [
        'displayErrorDetails' => getenv('APP_ENV') === 'dev',

        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ],
   'view' => new \Slim\Views\PhpRenderer(__DIR__ . '/../views'),

];