<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "companias".
 *
 * @property int $id
 * @property string $den_comp
 *
 * @property Vuelos[] $vuelos
 */
class Companias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['den_comp'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'den_comp' => 'Den Comp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVuelos()
    {
        return $this->hasMany(Vuelos::className(), ['comp_id' => 'id'])->inverseOf('comp');
    }
}
