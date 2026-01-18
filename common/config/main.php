<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    'components' => [
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => sprintf(
                'mysql:host=%s;port=%s;dbname=%s',
                getenv('DB_HOST') ?: 'db',
                getenv('DB_PORT') ?: 3306,
                getenv('DB_DATABASE') ?: 'vacancy'
            ),
            'username' => getenv('DB_USERNAME') ?: 'user',
            'password' => getenv('DB_PASSWORD') ?: 'password',
            'charset' => 'utf8',
        ],

        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
    ],
];
