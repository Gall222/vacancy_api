<?php

use \yii\db\Migration;

/**
 * Создание таблицы для вакансий
 */
class M160126143521CreateVacancyTable extends Migration
{
    private const TABLE_NAME = '{{%vacancy}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->comment('Заголовок')->notNull(),
            'description' => $this->text()->comment('Описание')->notNull(),
            'salary' => $this->integer()->comment('Зарплата')->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
