<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => 'User',
        ],
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => sprintf(
                'mysql:host=%s;dbname=%s',
                getenv('TEST_DB_HOST') ?: 'db_test',
                getenv('TEST_DB_DATABASE') ?: 'vacancy_test'
            ),
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
        ],
    ],
];
