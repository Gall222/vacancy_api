<?php

declare(strict_types=1);

return [
    'components' => [
        'db' => [
            'dsn' => sprintf(
                'mysql:host=%s;dbname=%s',
                getenv('TEST_DB_HOST') ?: 'db_test',
                getenv('TEST_DB_DATABASE') ?: 'vacancy_test'
            ),
            'username' => 'root',
            'password' => 'root',
        ],
    ]
];
