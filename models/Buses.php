<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "buses".
 *
 * @property int $id
 * @property string $model
 * @property int $average_speed
 * @property int $id_drivers
 *
 * @property Drivers $drivers
 */
class Buses extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{buses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['average_speed', 'id_drivers'], 'integer'],
            [['model'], 'string', 'max' => 255],
            [['id_drivers'], 'exist', 'skipOnError' => true, 'targetClass' => Drivers::className(), 'targetAttribute' => ['id_drivers' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'average_speed' => 'Average Speed',
            'id_drivers' => 'Id Drivers',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasOne(Drivers::className(), ['id' => 'id_drivers']);
    }

    public function extraFields()
    {
        return [
            'drivers',
        ];
    }
}
