<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ServerData */

$this->title = Yii::t('app', 'Create Server Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="server-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
