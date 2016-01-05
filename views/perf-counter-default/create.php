<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PerfCounterDefault */

$this->title = Yii::t('app', 'Create Perf Counter Default');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perf Counter Defaults'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perf-counter-default-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
