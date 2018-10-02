<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model app\models\ServerData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="server-data-form">

    <?php $form = ActiveForm::begin([
      'enableClientValidation' => false,
      'action' => ['server-data/update', 'pwdgen' => false, 'id' => $model->id]]); ?>

    <?php echo $form->field($model, 'Server')->textInput() ?>

    <?= $form->field($model, 'usertyp')->textInput() ?>

    <?php //echo $form->field($model, 'user')->textInput() ?>
    <?= $form->field($model, 'usr')->textInput() ?>

    <?php // echo $form->field($model, 'password')->passwordInput() ?>
    <?php echo $form->field($model, 'pwd')->widget(
    PasswordInput::classname()) ?>
        <?= Html::a(Yii::t('app', 'Generate new PW'), $model->isNewRecord ? Url::toRoute(['/server-data/create', 'pwdgen' => true]) 
                                                                          : Url::toRoute(['/server-data/update', 'id' => $model->id, 'pwdgen' => true]),[
        'data' => [
            'method' => 'post'
            ]
        ,'class' => 'btn btn-primary'
        ]) ?>

    <?= $form->field($model, 'snmp_pw')->textInput() ?>

    <?= $form->field($model, 'typ')->textInput() ?>

    <?php //echo $form->field($model, 'stat_wait')->textInput() ?>

    <?php //echo $form->field($model, 'stat_queries')->textInput() ?>

    <?php //echo $form->field($model, 'stat_cpu')->textInput() ?>

    <?php //echo $form->field($model, 'stat_mem')->textInput() ?>

    <?php //echo $form->field($model, 'stat_disk')->textInput() ?>

    <?php //echo $form->field($model, 'stat_sess')->textInput() ?>

    <?= $form->field($model, 'Description')->textInput() ?>

    <?= $form->field($model, 'lastEventlogSearch')->textInput() ?>

    <?= $form->field($model, 'paused')->checkBox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
