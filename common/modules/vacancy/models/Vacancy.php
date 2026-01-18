<?php

declare(strict_types=1);

namespace common\modules\vacancy\models;

use yii\db\ActiveRecord;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
use yii\validators\StringValidator;

/**
 * Модель вакансии
 *
 * @property integer $id
 * @property string $title Заголовок
 * @property string $description Описание
 * @property integer $salary  Зарплата
 * @property string $created_at Дата создания записи
 */
final class Vacancy extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%vacancy}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'description', 'salary'], RequiredValidator::class],
            [['salary'], NumberValidator::class],
            [['title', 'description'], StringValidator::class],
            [['created_at'], SafeValidator::class],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'id',
            'title',
            'description',
            'salary',
            'created_at',
        ];
    }
}
