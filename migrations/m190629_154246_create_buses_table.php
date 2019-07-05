<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%buses}}`.
 */
class m190629_154246_create_buses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%buses}}', [
            'id' => $this->primaryKey(),
            'model'=> $this->string(),
            'average_speed' => $this->integer(),
            'id_drivers' => $this->integer()
        ]);


        $this->addForeignKey(
            'buses_to_drivers',
            'buses',
            'id_drivers',
            'drivers',
            'id',
            'CASCADE'
        );

        $this->insert('{{%buses}}', ['model' => 'Ikarus', 'average_speed' => 50,'id_drivers' => '1']);
        $this->insert('{{%buses}}', ['model' => 'Fiat', 'average_speed' => '60','id_drivers' => '2']);
        $this->insert('{{%buses}}', ['model' => 'Skoda', 'average_speed' => '55','id_drivers' => '3']);
        $this->insert('{{%buses}}', ['model' => 'Krupp', 'average_speed' => '70','id_drivers' => '4']);
        $this->insert('{{%buses}}', ['model' => 'Berliet', 'average_speed' => '100','id_drivers' => '5']);
        $this->insert('{{%buses}}', ['model' => 'Fleetwood', 'average_speed' => '110','id_drivers' => '6']);
        $this->insert('{{%buses}}', ['model' => 'ПАГ', 'average_speed' => '150','id_drivers' => '7']);
        $this->insert('{{%buses}}', ['model' => 'AEC', 'average_speed' => '90','id_drivers' => '8']);
        $this->insert('{{%buses}}', ['model' => 'Renault', 'average_speed' => '160','id_drivers' => '9']);
        $this->insert('{{%buses}}', ['model' => 'Mercedes', 'average_speed' => '220','id_drivers' => '10']);
        $this->insert('{{%buses}}', ['model' => 'Ikarus', 'average_speed' => '50','id_drivers' => '3']);
        $this->insert('{{%buses}}', ['model' => 'Fiat', 'average_speed' => '60','id_drivers' => '3']);
        $this->insert('{{%buses}}', ['model' => 'Skoda', 'average_speed' => '55','id_drivers' => '5']);
        $this->insert('{{%buses}}', ['model' => 'Krupp', 'average_speed' => '70','id_drivers' => '8']);
        $this->insert('{{%buses}}', ['model' => 'Berliet', 'average_speed' => '100','id_drivers' => '1']);
        $this->insert('{{%buses}}', ['model' => 'Fleetwood', 'average_speed' => '110','id_drivers' => '1']);
        $this->insert('{{%buses}}', ['model' => 'ПАГ', 'average_speed' => '150','id_drivers' => '1']);
        $this->insert('{{%buses}}', ['model' => 'AEC', 'average_speed' => '90','id_drivers' => '4']);
        $this->insert('{{%buses}}', ['model' => 'Renault', 'average_speed' => '160','id_drivers' => '9']);
        $this->insert('{{%buses}}', ['model' => 'Mercedes', 'average_speed' => '220','id_drivers' => '6']);
        $this->insert('{{%buses}}', ['model' => 'Renault', 'average_speed' => '160','id_drivers' => '9']);
        $this->insert('{{%buses}}', ['model' => 'Mercedes', 'average_speed' => '220','id_drivers' => '10']);
        $this->insert('{{%buses}}', ['model' => 'Ikarus', 'average_speed' => '50','id_drivers' => '6']);
        $this->insert('{{%buses}}', ['model' => 'Fiat', 'average_speed' => '60','id_drivers' => '2']);
        $this->insert('{{%buses}}', ['model' => 'Skoda', 'average_speed' => '55','id_drivers' => '5']);
        $this->insert('{{%buses}}', ['model' => 'Krupp', 'average_speed' => '70','id_drivers' => '7']);
        $this->insert('{{%buses}}', ['model' => 'Berliet', 'average_speed' => '100','id_drivers' => '4']);
        $this->insert('{{%buses}}', ['model' => 'Fleetwood', 'average_speed' => '110','id_drivers' => '8']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%buses}}');
    }
}
