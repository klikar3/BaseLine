<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ConfigData */

$this->title = Yii::t('app', 'Create Config Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Config Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
