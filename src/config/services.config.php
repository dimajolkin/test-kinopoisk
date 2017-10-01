<?php

use app\service\kinopoisk\KinopoiskService;
use app\service\kinopoisk\provider\DbProvider;
use app\service\kinopoisk\provider\ParserKinopoiskProvider;
use app\service\kinopoisk\provider\CacheProvider;
use app\storage\RedisStorage;
use app\storage\StorageInterface;
use Doctrine\DBAL\Connection;
use Slim\Container;

return [
    KinopoiskService::class => function (Container $container) {

        return new KinopoiskService(
            $container->get(CacheProvider::class)
        );
    },
    DbProvider::class => function (Container $container) {

        return new DbProvider(
            $container->get(Connection::class)
        );
    },
    CacheProvider::class => function (Container $container) {

        return new CacheProvider(
            $container->get(DbProvider::class),
            $container->get(StorageInterface::class)
        );
    },
    ParserKinopoiskProvider::class => function () {

        return new ParserKinopoiskProvider();
    },

    StorageInterface::class => function () {
        $redis = new Redis();
        $redis->connect('localhost');

        return new RedisStorage($redis);
    },
    Connection::class => function () {

        $patch = realpath( __DIR__ . '/../../development_db');
        return \Doctrine\DBAL\DriverManager::getConnection([
            'pdo' => new PDO('sqlite:' . $patch),
        ]);
    }
];