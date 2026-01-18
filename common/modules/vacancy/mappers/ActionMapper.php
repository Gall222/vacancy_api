<?php

declare(strict_types=1);

namespace common\modules\vacancy\mappers;

use common\modules\vacancy\models\Vacancy;
use yii\web\UnprocessableEntityHttpException;

final class ActionMapper implements ActionMapperInterface
{
    /**
     * @throws UnprocessableEntityHttpException
     */
    public function newVacancy(array $formData): Vacancy
    {
        $vacancy = new Vacancy();
        $vacancy->load($formData, '');

        if($vacancy->validate() === false){
            throw new UnprocessableEntityHttpException($vacancy->errors);
        }

        return $vacancy;
    }
}
