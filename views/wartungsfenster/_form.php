<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Wartungsfenster $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="wartungsfenster-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ServerID')->textInput() ?>

    <?= $form->field($model, 'CaptureDate')->textInput() ?>

    <?= $form->field($model, 'quarter')->textInput() ?>

    <?= $form->field($model, 'w_value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
