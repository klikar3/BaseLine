<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServerDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="server-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Server') ?>

    <?= $form->field($model, 'usertyp') ?>

    <?= $form->field($model, 'user') ?>

    <?= $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'snmp_pw') ?>

    <?php // echo $form->field($model, 'typ') ?>

    <?php // echo $form->field($model, 'stat_wait') ?>

    <?php // echo $form->field($model, 'stat_queries') ?>

    <?php // echo $form->field($model, 'stat_cpu') ?>

    <?php // echo $form->field($model, 'stat_mem') ?>

    <?php // echo $form->field($model, 'stat_disk') ?>

    <?php // echo $form->field($model, 'stat_sess') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
