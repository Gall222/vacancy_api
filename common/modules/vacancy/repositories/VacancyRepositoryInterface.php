<?php

namespace common\modules\vacancy\repositories;

use common\modules\vacancy\models\Vacancy;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

interface VacancyRepositoryInterface
{
    public function findAll(int $page, int $pageSize): array;

    /**
     * @throws Exception Ошибка сохранения вакансии
     */
    public function save(Vacancy $vacancy): void;

    public function getAll(): array;

    /**
     * @throws NotFoundHttpException запись не найдена
     */
    public function get(int $id): Vacancy;
}