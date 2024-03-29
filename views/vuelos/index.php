<?php

use yii\grid\ActionColumn;

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vuelos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vuelos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Vuelos', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_vuelo',
            'orig_id',
            'dest_id',
            'comp_id',
            'salida:datetime',
            'libres:text:Plazas libres',
            //'llegada',
            // 'plazaslibres',
            //'precio',

            [
                'class' => ActionColumn::className(),
                'template' => '{reservar}',
                'header' => 'Reservar',
                'buttons' => [
                    'reservar' => function ($url, $model, $key) {
                        if ($model->libres > 0) {
                            return Html::beginForm(
                                ['reservas/create'],
                                'get'
                                )
                                . Html::hiddenInput('vuelo_id', $model->id)
                                . Html::submitButton(
                                    'Reservar',
                                    ['class' => 'btn btn-xs btn-success']
                                    )
                                    . Html::endForm();
                        } else {
                            return Html::tag('span', 'No disponible', ['class' => 'label label-default']);
                        }
                    },
                ],
            ],
        ],
    ]); ?>
</div>
