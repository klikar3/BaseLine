<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Wartungsfenster $model */

$this->title = 'Update Wartungsfenster: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wartungsfensters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wartungsfenster-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
