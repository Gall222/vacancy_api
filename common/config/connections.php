<?php

declare(strict_types=1);

return [
    'db' => [
        'dsn' => sprintf(
            'mysql:host=%s;dbname=%s',
            getenv('TEST_DB_HOST') ?: 'db_test',
            getenv('TEST_DB_DATABASE') ?: 'vacancy_test'
        ),
        'username' => getenv('TEST_DB_USERNAME') ?: 'user',
        'password' => getenv('TEST_DB_PASSWORD') ?: 'password',
    ],
];
