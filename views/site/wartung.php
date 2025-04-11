<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use kartik\widgets\StarRating;
use yii\web\JsExpression;

use app\controllers\ServerViewController;

/* @var $this yii\web\View */


$this->title = 'BaseLine';
?>
<?php
    $js = 'var autoRefresh = setInterval( function ()
    {
       window.location.reload();
    }, '.$refreshTime.'000); // this will reload page after every 1 minute.';

    $this->registerJs($js);
    date_default_timezone_set('Europe/Berlin'); 

?>
<div class="site-index">
    <div class="body-content">
       <div class="row">
          <div style="text-align:left;padding-left:0px;font-size:9pt;color:green" class="col-md-8"><?= 'Code Version 0.1'; ?></div> 
          <div style="text-align:right" class="col-md-4"><?= 'Refreshed on '.date('d.m.Y H:i:s'); ?></div>  
      </div> 
       <div class="row">      
      </div> 
      
       <div class="row">
          <?= GridView::widget([
              'dataProvider' => $dataProvider,
              'filterModel' => $searchModel,
              'tableOptions' => ['class' => 'table table-bordered'],
             'condensed' => true,
              'showHeader' => true,
              'filterPosition' => false,
              'columns' => [
                  [ 'class' => 'yii\grid\DataColumn',
                    'value' => 'id',
                    'options' => [ 'width' => '50px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'Server',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return Html::a($data->Server, ['/server-view/index', 'id' => $data->id]);
                     },
                    'options' => [ 'width' => '200px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;']
                  ],
/*                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'usertyp',
                    'options' => [ 'width' => '80px;'],
                  ],
*/                  [ 'class' => 'kartik\grid\DataColumn',
                    'attribute' => 'typ',
                    'options' => [ 'width' => '80px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;'],
                     'group' => true,
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_event',
                    'label' => 'Wartungsfenster',
                    'format' => 'raw',
                    'value' => function ($data) { return app\controllers\ServerViewController::getWartungBar($data->id,'Mo-Fr'); },
                    'options' => [ 'width' => '800px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;']
                  ],
//                   [ 'class' => 'yii\grid\ActionColumn',
//                    'options' => [ 'width' => '80px;']
//                  ],
              ],
          ]); ?>
<?php //echo \yii\helpers\VarDumper::dump($dataProvider, 10, true);
?>
       </div>
     </div>
</div>
