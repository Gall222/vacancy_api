<?php

declare(strict_types=1);

namespace common\tests\functional;

use common\modules\vacancy\models\Vacancy;
use common\modules\vacancy\repositories\VacancyRepositoryInterface;
use common\modules\vacancy\services\VacancyServiceInterface;
use common\tests\FunctionalTester;
use PHPUnit\Framework\Assert;
use Yii;

final class VacanciesCest
{
    private const VACANCIES = [
        'valid' => ['PHP Developer', 'Some description', 150_000],
        'middle' => ['Middle PHP Developer', 'Created via setVacancy', 200_000],
        'junior' => ['Junior PHP Developer', 'First vacancy', 100_000],
        'senior' => ['Senior PHP Developer', 'Second vacancy', 300_000],
    ];

    private VacancyRepositoryInterface $repository;
    private VacancyServiceInterface $service;

    public function __construct()
    {
        $this->repository = Yii::$container->get(VacancyRepositoryInterface::class);
        $this->service = Yii::$container->get(VacancyServiceInterface::class);
    }

    /** Хелпер для создания вакансии через репозиторий */
    private function createVacancy(string $title, string $description, int $salary): Vacancy
    {
        $vacancy = new Vacancy(['title' => $title, 'description' => $description, 'salary' => $salary]);
        $this->repository->save($vacancy);
        return $vacancy;
    }

    /** Хелпер для проверки записи в базе */
    private function assertVacancy(FunctionalTester $I, Vacancy $vacancy, string $title, string $description = null, int $salary = null): void
    {
        $criteria = ['id' => $vacancy->id, 'title' => $title];
        if ($description !== null) $criteria['description'] = $description;
        if ($salary !== null) $criteria['salary'] = $salary;

        $I->seeRecord(Vacancy::class, $criteria);
    }

    public function createVacancyViaService(FunctionalTester $I): void
    {
        [$title, $description, $salary] = self::VACANCIES['valid'];
        $vacancy = $this->service->create(compact('title', 'description', 'salary'));

        Assert::assertInstanceOf(Vacancy::class, $vacancy);
        Assert::assertNotEmpty($vacancy->id);

        $this->assertVacancy($I, $vacancy, $title, $description, $salary);
    }

    public function getVacancyViaService(FunctionalTester $I): void
    {
        [$title, $description, $salary] = self::VACANCIES['middle'];
        $vacancy = $this->createVacancy($title, $description, $salary);

        $fetched = $this->service->get($vacancy->id);

        Assert::assertInstanceOf(Vacancy::class, $fetched);
        Assert::assertSame($vacancy->id, $fetched->id);
        Assert::assertSame($title, $fetched->title);

        $this->assertVacancy($I, $fetched, $title);
    }

    public function getAllVacanciesViaService(FunctionalTester $I): void
    {
        $first = $this->createVacancy(...self::VACANCIES['junior']);
        $second = $this->createVacancy(...self::VACANCIES['senior']);

        $all = $this->service->getAll();

        Assert::assertIsArray($all);
        Assert::assertNotEmpty($all);

        $ids = array_map(fn(Vacancy $v) => $v->id, $all);
        Assert::assertContains($first->id, $ids);
        Assert::assertContains($second->id, $ids);

        $this->assertVacancy($I, $first, ...self::VACANCIES['junior']);
        $this->assertVacancy($I, $second, ...self::VACANCIES['senior']);
    }
}
