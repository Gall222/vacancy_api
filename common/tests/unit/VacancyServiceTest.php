<?php

declare(strict_types=1);

namespace common\tests\unit\services;

use Codeception\Test\Unit;
use common\modules\vacancy\models\Vacancy;
use common\modules\vacancy\repositories\VacancyRepositoryInterface;
use common\modules\vacancy\mappers\ActionMapperInterface;
use common\modules\vacancy\services\VacancyService;
use PHPUnit\Framework\MockObject\MockObject;
use yii\db\Exception;

class VacancyServiceTest extends Unit
{
    private VacancyService $service;

    /** @var VacancyRepositoryInterface&MockObject */
    private $repository;

    /** @var ActionMapperInterface&MockObject */
    private $mapper;

    protected function _before(): void
    {
        $this->repository = $this->createMock(VacancyRepositoryInterface::class);
        $this->mapper = $this->createMock(ActionMapperInterface::class);
        $this->service = new VacancyService($this->repository, $this->mapper);
    }

    public function testCreateVacancySuccess(): void
    {
        // Arrange
        $formData = [
            'title' => 'PHP Developer',
            'description' => 'We are looking for PHP developer...',
            'salary' => 150000
        ];

        $expectedVacancy = new Vacancy();
        $expectedVacancy->title = $formData['title'];
        $expectedVacancy->description = $formData['description'];
        $expectedVacancy->salary = $formData['salary'];

        $this->mapper
            ->expects($this->once())
            ->method('newVacancy')
            ->with($formData)
            ->willReturn($expectedVacancy);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($expectedVacancy);

        // Act
        $result = $this->service->create($formData);

        // Assert
        $this->assertInstanceOf(Vacancy::class, $result);
        $this->assertEquals($expectedVacancy, $result);
        $this->assertEquals($formData['title'], $result->title);
        $this->assertEquals($formData['description'], $result->description);
        $this->assertEquals($formData['salary'], $result->salary);
    }

    public function testCreateVacancyWithEmptyData(): void
    {
        // Arrange
        $formData = [
            'title' => '',
            'description' => '',
            'salary' => 0
        ];

        $expectedVacancy = new Vacancy();
        $expectedVacancy->title = '';
        $expectedVacancy->description = '';
        $expectedVacancy->salary = 0;

        $this->mapper
            ->expects($this->once())
            ->method('newVacancy')
            ->with($formData)
            ->willReturn($expectedVacancy);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($expectedVacancy);

        // Act
        $result = $this->service->create($formData);

        // Assert
        $this->assertInstanceOf(Vacancy::class, $result);
        $this->assertEquals('', $result->title);
        $this->assertEquals('', $result->description);
        $this->assertEquals(0, $result->salary);
    }

    public function testCreateVacancyThrowsExceptionOnSave(): void
    {
        // Arrange
        $formData = [
            'title' => 'Test Vacancy',
            'description' => 'Test Description',
            'salary' => 100000
        ];

        $vacancy = new Vacancy();
        $vacancy->title = $formData['title'];

        $this->mapper
            ->expects($this->once())
            ->method('newVacancy')
            ->with($formData)
            ->willReturn($vacancy);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($vacancy)
            ->willThrowException(new Exception('Database error'));

        // Assert & Expect
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Database error');

        // Act
        $this->service->create($formData);
    }

    public function testGetAllVacancies(): void
    {
        // Arrange
        $expectedVacancies = [
            $this->createMockVacancy(1, 'PHP Developer', 150000),
            $this->createMockVacancy(2, 'JavaScript Developer', 140000),
            $this->createMockVacancy(3, 'Python Developer', 160000)
        ];

        $this->repository
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($expectedVacancies);

        // Act
        $result = $this->service->getAll();

        // Assert
        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertEquals($expectedVacancies, $result);
    }

    public function testGetAllVacanciesWhenEmpty(): void
    {
        // Arrange
        $this->repository
            ->expects($this->once())
            ->method('getAll')
            ->willReturn([]);

        // Act
        $result = $this->service->getAll();

        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testGetVacancyById(): void
    {
        // Arrange
        $vacancyId = 1;
        $expectedVacancy = $this->createMockVacancy($vacancyId, 'PHP Developer', 150000);

        $this->repository
            ->expects($this->once())
            ->method('get')
            ->with($vacancyId)
            ->willReturn($expectedVacancy);

        // Act
        $result = $this->service->get($vacancyId);

        // Assert
        $this->assertInstanceOf(Vacancy::class, $result);
        $this->assertEquals($vacancyId, $result->id);
        $this->assertEquals($expectedVacancy, $result);
    }

    public function testGetVacancyByIdNotFound(): void
    {
        // Arrange
        $vacancyId = 999;

        $this->repository
            ->expects($this->once())
            ->method('get')
            ->with($vacancyId)
            ->willThrowException(new Exception('Vacancy not found'));

        // Assert & Expect
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Vacancy not found');

        // Act
        $this->service->get($vacancyId);
    }

    public function testGetVacancyWithInvalidId(): void
    {
        // Arrange
        $invalidId = -1;

        $this->repository
            ->expects($this->once())
            ->method('get')
            ->with($invalidId)
            ->willThrowException(new Exception('Invalid vacancy ID'));

        // Assert & Expect
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid vacancy ID');

        // Act
        $this->service->get($invalidId);
    }

    /**
     * @dataProvider vacancyDataProvider
     */
    public function testCreateVacancyWithDifferentData(
        array $formData,
        string $expectedTitle,
        int $expectedSalary
    ): void {
        // Arrange
        $vacancy = new Vacancy();
        $vacancy->title = $expectedTitle;
        $vacancy->salary = $expectedSalary;

        $this->mapper
            ->expects($this->once())
            ->method('newVacancy')
            ->with($formData)
            ->willReturn($vacancy);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($vacancy);

        // Act
        $result = $this->service->create($formData);

        // Assert
        $this->assertEquals($expectedTitle, $result->title);
        $this->assertEquals($expectedSalary, $result->salary);
    }

    public function vacancyDataProvider(): array
    {
        return [
            'high salary' => [
                ['title' => 'Senior Developer', 'description' => 'Senior position', 'salary' => 300000],
                'Senior Developer',
                300000
            ],
            'medium salary' => [
                ['title' => 'Middle Developer', 'description' => 'Middle position', 'salary' => 200000],
                'Middle Developer',
                200000
            ],
            'low salary' => [
                ['title' => 'Junior Developer', 'description' => 'Junior position', 'salary' => 100000],
                'Junior Developer',
                100000
            ],
            'with special characters' => [
                ['title' => 'PHP & Laravel Developer', 'description' => 'Special chars: !@#$%', 'salary' => 150000],
                'PHP & Laravel Developer',
                150000
            ],
            'long title' => [
                ['title' => str_repeat('A', 255), 'description' => 'Long title test', 'salary' => 100000],
                str_repeat('A', 255),
                100000
            ]
        ];
    }

    private function createMockVacancy(int $id, string $title, int $salary): Vacancy
    {
        $vacancy = new Vacancy();
        $vacancy->id = $id;
        $vacancy->title = $title;
        $vacancy->salary = $salary;
        $vacancy->description = 'Description for ' . $title;
        $vacancy->created_at = date('Y-m-d H:i:s');

        return $vacancy;
    }
}