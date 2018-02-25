<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $vuelo_id
 * @property string $asiento
 * @property string $fecha_hora
 *
 * @property Usuarios $usuario
 * @property Vuelos $vuelo
 */
class Reservas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'vuelo_id', 'asiento'], 'required'],
            [['usuario_id', 'vuelo_id'], 'default', 'value' => null],
            [['usuario_id', 'vuelo_id'], 'integer'],
            [
                ['usuario_id', 'vuelo_id'],
                'unique',
                'targetAttribute' => ['usuario_id', 'vuelo_id'],
                'message' => 'Ya tiene reserva en este vuelo',
            ],
            [['asiento'], 'integer', 'min' => 1],
            [['asiento'], function ($attribute, $params, $validator) {
                $vuelo = Vuelos::findOne($this->vuelo_id);
                if ($vuelo !== null) {
                    if (!$vuelo->getAsientoLibre($this->$attribute)) {
                        $this->addError($attribute, 'Este asiento ya está asignado');
                    } elseif ($this->$attribute > $vuelo->plazas) {
                        $this->addError($attribute, 'El número máximo de asiento es el ' . $vuelo->plazas);
                    }
                }
            }],
            [['fecha_hora'], 'safe'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['vuelo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vuelos::className(), 'targetAttribute' => ['vuelo_id' => 'id']],
            [['vuelo_id'], function ($attribute, $params, $validator) {
                if (!Vuelos::findOne($this->$attribute)->tieneplazaslibres) {
                    $this->addError($attribute, 'Este vuelo no tiene más plazas libres');
                }
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'vuelo_id' => 'Vuelo ID',
            'asiento' => 'Asiento',
            'fecha_hora' => 'Fecha reserva',
        ];
    }
    //
    // public function beforeValidate()
    // {
    //     parent::beforeValidate();
    //     if (!$this->vuelo->tieneplazaslibres) {
    //         Yii::$app->session->setFlash('error', 'Este vuelo no tiene más plazas libres');
    //         return false;
    //     }
    //     return true;
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('reservas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVuelo()
    {
        return $this->hasOne(Vuelos::className(), ['id' => 'vuelo_id'])->inverseOf('reservas');
    }
}
