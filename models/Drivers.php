<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "drivers".
 *
 * @property int $id
 * @property string $name
 * @property int $birth_year
 *
 * @property Buses[] $buses
 */
class Drivers extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drivers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['birth_year', 'integer'],
            ['name', 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'birth_year' => 'Birth Year',
            'age' => 'Age',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBuses()
    {
        return $this->hasMany(Buses::className(), ['id_drivers' => 'id']);
    }

    public function extraFields()
    {
        return [
            'buses',
        ];
    }

}
