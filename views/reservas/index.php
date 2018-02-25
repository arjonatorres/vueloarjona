<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Reservas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'usuario.nombre',
            'asiento',
            'fecha_hora',
            'vuelo.comp.den_comp',
            'vuelo.salida:datetime',
            'vuelo.llegada:datetime',
            [
                'label' => 'Aeropuerto origen',
                'attribute' => 'vuelo.orig.den_aero',
            ],
            [
                'label' => 'Aeropuerto destino',
                'attribute' => 'vuelo.dest.den_aero',
            ],
            'vuelo.precio:currency',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
