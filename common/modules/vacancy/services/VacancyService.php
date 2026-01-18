<?php

declare(strict_types=1);

namespace common\modules\vacancy\services;

use common\modules\vacancy\mappers\ActionMapperInterface;
use common\modules\vacancy\models\Vacancy;
use common\modules\vacancy\repositories\VacancyRepositoryInterface;
use yii\db\Exception;

final class VacancyService implements VacancyServiceInterface
{
    public function __construct(
        private VacancyRepositoryInterface $repository,
        private ActionMapperInterface $mapper
    ) {}

    /**
     * @throws Exception
     */
    public function create(array $formData): Vacancy
    {
        $vacancy = $this->mapper->newVacancy($formData);
        $this->repository->save($vacancy);

        return $vacancy;
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function get(int $id): Vacancy
    {
        return $this->repository->get($id);
    }
}
