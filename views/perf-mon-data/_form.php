<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerfMonData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perf-mon-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Server')->textInput() ?>

    <?= $form->field($model, 'Counter')->textInput() ?>

    <?= $form->field($model, 'Value')->textInput() ?>

    <?= $form->field($model, 'CaptureDate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
