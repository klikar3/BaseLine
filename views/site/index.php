<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use app\controllers\ServerViewController;

/* @var $this yii\web\View */

$this->title = 'BaseLine';
?>
<?php

    $this->registerJs(
       'var autoRefresh = setInterval( function ()
    {
       window.location.reload();
    }, 20000); // this will reload page after every 1 minute.
'
    );
    date_default_timezone_set('Europe/Berlin'); 

?>
<div class="site-index">
    <div class="body-content">
       <div class="row">
          <div style="text-align:left;padding-left:0px;font-size:9pt;color:green" class="col-md-8"><?= 'Code Version 0.1'; ?></div> 
          <div style="text-align:right" class="col-md-4"><?= 'Refreshed on '.date('d.m.Y H:i:s'); ?></div>  
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
                  [ 'attribute' => 'paused',
                    'format' => 'raw',
                    'value' => function ($model, $index, $widget) {
                        return Html::checkbox('paused[]', $model->paused, ['value' => $index, 'disabled' => true]);
                    },
                    'options' => [ 'width' => '50px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_event',
                    'format' => 'raw',
                    'value' => function ($data) { return app\controllers\ServerViewController::getStatusimage($data->stat_event, $data->id,'/server-view/index', $data->paused); },
                    'options' => [ 'width' => '50px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_wait',
                    'format' => 'raw',
                    'value' => function ($data) { return app\controllers\ServerViewController::getWaitimage($data->stat_wait, $data->id,'/server-view/index', $data->paused); },
                    'options' => [ 'width' => '50px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_queries',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_queries, $data->id, '/server-view/index', $data->paused);
                     },
                    'options' => [ 'width' => '20px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_cpu',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_cpu, $data->id, '/server-view/res_cpu', $data->paused);
                     },
                    'options' => [ 'width' => '20px;' ],
                    'headerOptions' => ['style' => 'background-color: lightblue;'],
                    'contentOptions' => function ($model, $key, $index, $column) {
                            return ['style' => 'background-color:' 
                                . ( strpos($model->stat_cpu,'U')>0 ? 'khaki' : 'white'), 'title' => strpos($model->stat_cpu,'U')>0 ? 'Ungewöhnlicher Wert' : '' ];
                        },
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_mem',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_mem, $data->id, '/server-view/res_mem', $data->paused);
                     },
                    'options' => [ 'width' => '20px;' ],
                     'headerOptions' => ['style' => 'background-color: lightblue;'],
                    'contentOptions' => function ($model, $key, $index, $column) {
                            return ['style' => 'background-color:' 
                                . ( strpos($model->stat_mem,'U')>0 ? 'khaki' : 'white')];
                        },

                  ],
                  [ 'class' => 'yii\grid\DataColumn', 
                    'attribute' => 'stat_disk',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_disk, $data->id, '/server-view/res_disk', $data->paused);
                     },
                    'options' => [ 'width' => '20px;' ],
                     'headerOptions' => ['style' => 'background-color: lightblue;'],
                    'contentOptions' => function ($model, $key, $index, $column) {
                            return ['style' => 'background-color:' 
                                . ( strpos($model->stat_disk,'U')>0 ? 'khaki' : 'white')];
                        },

                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_sess',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_sess, $data->id, '/server-view/res_sess', $data->paused);
                     },
                    'options' => [ 'width' => '20px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;'],
                    'contentOptions' => function ($model, $key, $index, $column) {
                            return ['style' => 'background-color:' 
                                . ( strpos($model->stat_sess,'U')>0 ? 'khaki' : 'white')];
                        },

                  ],
                   [ 'class' => 'yii\grid\DataColumn',
                      'attribute' => 'stat_net',
                      'format' => 'raw',
                      'value' => function ($data) {
                           return app\controllers\ServerViewController::getStatusimage($data->stat_net, $data->id, '/server-view/res_net', $data->paused);
                       },
                      'options' => [ 'width' => '20px;'],
                     'headerOptions' => ['style' => 'background-color: lightblue;'],
                     'contentOptions' => function ($model, $key, $index, $column) {
                            return ['style' => 'background-color:' 
                                . ( strpos($model->stat_net,'U')>0 ? 'khaki' : 'white')];
                        },

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
