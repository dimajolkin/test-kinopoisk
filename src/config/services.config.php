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
    /**
     * Кэширует данные во временное хранилище от любого провайдера
     */
    CacheProvider::class => function (Container $container) {

        // будет получать с сайта и кэшировать
        return new CacheProvider(
            $container->get(ParserKinopoiskProvider::class),
            $container->get(StorageInterface::class)
        );

//        // получение данных из бызы
//        return new CacheProvider(
//            $container->get(DbProvider::class),
//            $container->get(StorageInterface::class)
//        );

    },
    /**
     * Ищет в записанных в базу данных
     */
    DbProvider::class => function (Container $container) {

        return new DbProvider(
            $container->get(Connection::class)
        );
    },
    /**
     * Провайдер получает данные с сайта путём парсинга  HTML
     */
    ParserKinopoiskProvider::class => function () {

        return new ParserKinopoiskProvider();
    },

    StorageInterface::class => function () {
        $redis = new Redis();
        $redis->connect(getenv('DB_REDIS_HOST') ?: 'localhost');

        return new RedisStorage($redis);
    },
    Connection::class => function () {

        $patch = realpath( __DIR__ . '/../../development_db');
        return \Doctrine\DBAL\DriverManager::getConnection([
            'pdo' => new PDO('sqlite:' . $patch),
        ]);
    }
];