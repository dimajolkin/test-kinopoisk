<?php

return [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        ],
        'environments' =>
            [
                'default_database' => 'default',
                'default_migration_table' => 'phinxlog',
                'default' =>
                    [
                        'adapter' => getenv('DB_DRIVER'),
                        'host' => getenv('DB_HOST'),
                        'name' => getenv('DB_NAME'),
                        'user' => getenv('DB_USER'),
                        'pass' => getenv('DB_PASSWORD'),
                    ],

            ],
    ];