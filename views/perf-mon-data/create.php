<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PerfMonData */

$this->title = Yii::t('app', 'Create Perf Mon Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perf Mon Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perf-mon-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
