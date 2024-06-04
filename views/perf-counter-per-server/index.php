<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerfCounterPerServerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Perf Counter Per Servers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perf-counter-per-server-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Perf Counter Per Server'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'Server',
            'counter_id',
            'counter_name',
            'instance',
            // 'AvgValue',
            // 'StdDevValue',
            // 'WarnValue',
            // 'AlertValue',
            // 'is_perfmon',
            // 'direction',
            'belongsto',
            'status',

            ['class' => 'yii\grid\ActionColumn','options' => [ 'width' => '70px;']],
        ],
    ]); ?>

</div>
