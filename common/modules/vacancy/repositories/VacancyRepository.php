<?php

declare(strict_types=1);

namespace common\modules\vacancy\repositories;

use common\modules\vacancy\models\Vacancy;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

final class VacancyRepository implements VacancyRepositoryInterface
{
    public function findAll(int $page, int $pageSize): array
    {
        return Vacancy::find()
            ->offset(($page - 1) * $pageSize)
            ->limit($pageSize)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }

    /**
     * @throws Exception
     */
    public function save(Vacancy $vacancy): void
    {
        if ($vacancy->save() === false) {
            throw new Exception('Vacancy save error');
        }
    }

    public function getAll(): array
    {
        return Vacancy::find()->all();
    }

    public function get(int $id): Vacancy
    {
        $vacancy = Vacancy::findOne($id);

        if ($vacancy === null) {
            throw new NotFoundHttpException('Vacancy not found');
        }

        return $vacancy;
    }
}
