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

    <?= $form->field($model, 'AvgValue')->textInput() ?>

    <?= $form->field($model, 'StdDefValue')->textInput() ?>

    <?= $form->field($model, 'WarnValue')->textInput() ?>

    <?= $form->field($model, 'AlertValue')->textInput() ?>

    <?= $form->field($model, 'is_perfmon')->textInput() ?>

    <?= $form->field($model, 'direction')->textInput() ?>

    <?= $form->field($model, 'belongsto')->textInput() ?>

    <?= $form->field($model, 'Description')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
