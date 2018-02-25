<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vuelos".
 *
 * @property int $id
 * @property string $id_vuelo
 * @property int $orig_id
 * @property int $dest_id
 * @property int $comp_id
 * @property string $salida
 * @property string $llegada
 * @property string $plazas
 * @property string $precio
 *
 * @property Reservas[] $reservas
 * @property Aeropuertos $orig
 * @property Aeropuertos $dest
 * @property Companias $comp
 */
class Vuelos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vuelos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_vuelo', 'orig_id', 'dest_id', 'comp_id', 'salida', 'llegada', 'plazas', 'precio'], 'required'],
            [['orig_id', 'dest_id', 'comp_id'], 'default', 'value' => null],
            [['orig_id', 'dest_id', 'comp_id'], 'integer'],
            [['salida', 'llegada'], 'safe'],
            [['plazas', 'precio'], 'number'],
            [['id_vuelo'], 'string', 'max' => 6],
            [['orig_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aeropuertos::className(), 'targetAttribute' => ['orig_id' => 'id']],
            [['dest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aeropuertos::className(), 'targetAttribute' => ['dest_id' => 'id']],
            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companias::className(), 'targetAttribute' => ['comp_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_vuelo' => 'Id Vuelo',
            'orig_id' => 'Orig ID',
            'dest_id' => 'Dest ID',
            'comp_id' => 'Comp ID',
            'salida' => 'Salida',
            'llegada' => 'Llegada',
            'plazas' => 'Plazas',
            'precio' => 'Precio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reservas::className(), ['vuelo_id' => 'id'])->inverseOf('vuelo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrig()
    {
        return $this->hasOne(Aeropuertos::className(), ['id' => 'orig_id'])->inverseOf('vuelos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDest()
    {
        return $this->hasOne(Aeropuertos::className(), ['id' => 'dest_id'])->inverseOf('vuelos0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComp()
    {
        return $this->hasOne(Companias::className(), ['id' => 'comp_id'])->inverseOf('vuelos');
    }
}
