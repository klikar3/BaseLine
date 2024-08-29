<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Wartungsfenster $model */

$this->title = 'Create Wartungsfenster';
$this->params['breadcrumbs'][] = ['label' => 'Wartungsfensters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wartungsfenster-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
