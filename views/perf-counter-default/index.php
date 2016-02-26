<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerfCounterDefaultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Perf Counter Defaults');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perf-counter-default-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Perf Counter Default'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'counter_name',
            'AvgValue',
            'StdDefValue',
            'WarnValue',
            'AlertValue',
            'is_perfmon',
            'direction',
            'belongsto',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
