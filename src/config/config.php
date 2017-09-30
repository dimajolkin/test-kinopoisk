<?php

use app\service\kinopoisk\KinopoiskService;

return [
    'settings' => [

    ],
    KinopoiskService::class => function () {
        return new KinopoiskService();
    },
];