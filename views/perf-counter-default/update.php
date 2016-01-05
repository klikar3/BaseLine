<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PerfCounterDefault */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Perf Counter Default',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perf Counter Defaults'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="perf-counter-default-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
