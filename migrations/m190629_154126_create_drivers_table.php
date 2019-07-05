<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%drivers}}`.
 */
class m190629_154126_create_drivers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%drivers}}', [
            'id' => $this->primaryKey(),
            'name'=> $this->string(),
            'birth_year' => $this->integer(),
        ]);
        $this->insert('{{%drivers}}', ['name' => 'Петров Александр Васильевич', 'birth_year' => '1977']);
        $this->insert('{{%drivers}}', ['name' => 'Григорин Петр Ильич', 'birth_year' => '1965']);
        $this->insert('{{%drivers}}', ['name' => 'Абакидзе Анур Шотаевич', 'birth_year' => '1955']);
        $this->insert('{{%drivers}}', ['name' => 'Прилепин Виктор Михайлович', 'birth_year' => '1967']);
        $this->insert('{{%drivers}}', ['name' => 'Васильев Владислав Сергеевич', 'birth_year' => '1958']);
        $this->insert('{{%drivers}}', ['name' => 'Григорян Арам Егорович', 'birth_year' => '1944']);
        $this->insert('{{%drivers}}', ['name' => 'Ильин Василий Андреевич', 'birth_year' => '1961']);
        $this->insert('{{%drivers}}', ['name' => 'Ситников Денис Владимирович', 'birth_year' => '1990']);
        $this->insert('{{%drivers}}', ['name' => 'Трапаридзе Виктор Дмитриевич', 'birth_year' => '1981']);
        $this->insert('{{%drivers}}', ['name' => 'Краскин Дмитрий Витальевич', 'birth_year' => '1958']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%drivers}}');
    }
}
