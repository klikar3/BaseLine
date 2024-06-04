<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerfCounterPerServer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perf-counter-per-server-form">
<div class="row">
<div class="col col-lg-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Server')->textInput() ?>

    <?= $form->field($model, 'counter_id')->textInput() ?>

    <?= $form->field($model, 'counter_name')->textInput() ?>

    <?= $form->field($model, 'instance')->textInput() ?>

    <?= $form->field($model, 'WarnValue')->textInput() ?>

    <?= $form->field($model, 'AlertValue')->textInput() ?>

    <?= $form->field($model, 'is_perfmon')->textInput() ?>

    <?= $form->field($model, 'direction')->textInput() ?>

    <?= $form->field($model, 'belongsto')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

</div>
<div class="col col-lg-6">
    <?= $form->field($model, 'server_id')->textInput() ?>

    <?= $form->field($model, 'lastDate')->textInput() ?>

    <?= $form->field($model, 'lastValue')->textInput() ?>

    <?= $form->field($model, 'AvgValue')->textInput() ?>

    <?= $form->field($model, 'StdDevValue')->textInput() ?>

    <?= $form->field($model, 'Avg5WeekAvg')->textInput() ?>

    <?= $form->field($model, 'Avg5WeekStdDev')->textInput() ?>
        

</div>
</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
