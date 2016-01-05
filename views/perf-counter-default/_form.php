<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerfCounterDefault */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perf-counter-default-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'counter_name')->textInput() ?>

    <?= $form->field($model, 'MinValue')->textInput() ?>

    <?= $form->field($model, 'MaxValue')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
