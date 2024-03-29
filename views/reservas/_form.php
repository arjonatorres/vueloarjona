<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Reservas */
/* @var $form yii\widgets\ActiveForm */

// $urlVueloPlazasLibres = Url::to(['vuelos/plazas-libres']);
//
// $js = <<<EOT
//     $('#vuelo').on('blur', function() {
//         $.getJSON(
//             '$urlVueloPlazasLibres',
//             {vuelo_id: $(this).val()},
//             mostrar
//         );
//     });
//
//     function mostrar(data) {
//         $('#lista').empty();
//         if (data.length == 0) {
//             var elem = $('<option>Vuelo completo</option>');
//             $('#lista').append(elem);
//         } else if (data == -1) {
//             var elem = $('<option>El vuelo no existe</option>');
//             $('#lista').append(elem);
//         } else {
//             $.each(data, function (key, value) {
//                 var elem = $('<option>' + value + '</option>').val(value);
//                 $('#lista').append(elem);
//             });
//         }
//     }
//
// EOT;
//
// $this->registerJs($js);

?>

<div class="reservas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($model, 'usuario_id') ?>

    <?= Html::activeHiddenInput($model, 'vuelo_id') ?>

    <?= $form->field($model, 'asiento')->dropDownList($asientos, ['id' => 'lista']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
