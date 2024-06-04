<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PerfMonData */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Perf Mon Data',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perf Mon Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="perf-mon-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
