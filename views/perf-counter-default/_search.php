<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerfCounterDefaultSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perf-counter-default-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'counter_name') ?>

    <?= $form->field($model, 'AvgValue') ?>

    <?= $form->field($model, 'StdDefValue') ?>

    <?= $form->field($model, 'WarnValue') ?>

    <?php // echo $form->field($model, 'AlertValue') ?>

    <?php // echo $form->field($model, 'is_perfmon') ?>

    <?php // echo $form->field($model, 'direction') ?>

    <?php // echo $form->field($model, 'belongsto') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
