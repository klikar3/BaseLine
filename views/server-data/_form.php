<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServerData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="server-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Server')->textInput() ?>

    <?= $form->field($model, 'usertyp')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'snmp_pw')->textInput() ?>

    <?= $form->field($model, 'typ')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
