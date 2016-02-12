<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PerfCounterPerServer */

$this->title = Yii::t('app', 'Create Perf Counter Per Server');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perf Counter Per Servers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perf-counter-per-server-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
