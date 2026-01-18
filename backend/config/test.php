<?php
return [
    'id' => 'app-backend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => sprintf(
                'mysql:host=%s;dbname=%s',
                getenv('TEST_DB_HOST') ?: 'db_test',
                getenv('TEST_DB_DATABASE') ?: 'vacancy_test'
            ),
            'username' => getenv('TEST_DB_USERNAME') ?: 'user',
            'password' => getenv('TEST_DB_PASSWORD') ?: 'password',
            'charset' => 'utf8mb4',
        ],
    ],
];
