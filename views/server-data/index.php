<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServerDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Server Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="server-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Server Data'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\DataColumn',
              'value' => 'id',
              'options' => [ 'width' => '50px;']
            ],
            'Server',
            'usertyp',
            'user',
            'password',
            'snmp_pw',
            'typ',
            'stat_wait',
		        'stat_queries',
		        'stat_cpu',
		        'stat_mem',
		        'stat_disk',
		        'stat_sess',	
            ['class' => 'yii\grid\ActionColumn',
              'options' => [ 'width' => '80px;']
            ],
        ],
    ]); ?>

</div>
