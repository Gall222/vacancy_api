<?php

namespace common\modules\vacancy\services;

use common\modules\vacancy\models\Vacancy;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

interface VacancyServiceInterface
{
    /**
     * @throws Exception Ошибка сохранения вакансии
     */
    public function create(array $formData): Vacancy;

    public function getAll(): array;

    /**
     * @throws NotFoundHttpException запись не найдена
     */
    public function get(int $id);
}