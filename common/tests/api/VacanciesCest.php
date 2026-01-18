<?php

declare(strict_types=1);

namespace api;


use common\tests\ApiTester;

final class VacanciesCest
{
    public function getVacancies(ApiTester $I): void
    {
        $I->sendGet('/vacancies');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            [
                'id' => 'integer',
                'title' => 'string',
                'salary' => 'float|integer',
            ]
        ]);
    }

    public function createVacancy(ApiTester $I): void
    {
        $I->sendPost('/vacancies', [
            'title' => 'PHP Developer',
            'description' => 'Backend developer',
            'salary' => 3000,
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'title' => 'string',
            'description' => 'string',
            'salary' => 'float|integer',
        ]);
    }

    public function getVacancyById(ApiTester $I): void
    {
        // создаём вакансию
        $I->sendPost('/vacancies', [
            'title' => 'QA Engineer',
            'description' => 'Testing',
            'salary' => 2000,
        ]);

        $id = $I->grabDataFromResponseByJsonPath('$.id')[0];

        $I->sendGet("/vacancies/{$id}");

        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'title' => 'string',
            'description' => 'string',
            'salary' => 'float|integer',
        ]);
    }

    public function getVacancyNotFound(ApiTester $I): void
    {
        $I->sendGet('/vacancies/999999');

        $I->seeResponseCodeIs(404);
    }

    public function createVacancyValidationError(ApiTester $I): void
    {
        $I->sendPost('/vacancies', [
            'title' => '',
        ]);

        $I->seeResponseCodeIs(422);
    }
}
