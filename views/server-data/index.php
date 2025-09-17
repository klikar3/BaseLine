<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax; 

//use kartik\grid\GridView;
		
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServerDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Serverdaten');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
    $js = 'var autoRefresh = setInterval( function ()
    {
       window.location.reload();
    }, '.$refreshTime.'000); // this will reload page after every 1 minute.';

    $this->registerJs($js);
    date_default_timezone_set('Europe/Berlin'); 

?>
<div class="server-data-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Server Data'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <?php Pjax::begin(); ?> 
		
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
		    [ 'attribute' => 'id',
              'class' => 'yii\grid\DataColumn',
              'value' => 'id',
              'options' => [ 'width' => '50px;']
            ],
            [ 'attribute' => 'Server',
              'class' => 'yii\grid\DataColumn',
              'value' => 'Server',
              'options' => [ 'width' => '200px;']
            ],
            'sql_connect',
            'usertyp',
//            'user',
//            'usr',
//            'password',
//            'pwd',
            'snmp_pw',
            [ 'attribute' => 'typ',
              'class' => 'yii\grid\DataColumn',
              'value' => 'typ',
              'options' => [ 'width' => '50px;']
            ],
            'paused',
            'stat_wait',
		        'stat_queries',
		        'stat_cpu',
		        'stat_mem',
		        'stat_disk',
		        'stat_sess',	
		        'stat_net',
//            'lastEventlogSearch',	
           ['class' => 'yii\grid\ActionColumn',
              'options' => [ 'width' => '120px;']
            ],
        ],
    ]); ?>
 	   <?php Pjax::end(); ?> 
	
</div>
