<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerfCounterPerServerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perf-counter-per-server-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Server') ?>

    <?= $form->field($model, 'counter_id') ?>

    <?= $form->field($model, 'counter_name') ?>

    <?= $form->field($model, 'instance') ?>

    <?php // echo $form->field($model, 'AvgValue') ?>

    <?php // echo $form->field($model, 'StdDevValue') ?>

    <?php // echo $form->field($model, 'WarnValue') ?>

    <?php // echo $form->field($model, 'AlertValue') ?>

    <?php // echo $form->field($model, 'is_perfmon') ?>

    <?php // echo $form->field($model, 'direction') ?>

    <?php // echo $form->field($model, 'belongsto') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
