<?php

namespace common\modules\vacancy\mappers;

use common\modules\vacancy\models\Vacancy;

interface ActionMapperInterface
{
    public function newVacancy(array $formData): Vacancy;
}