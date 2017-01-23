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
<div style="text-align: right"><?= 'Refreshed on '.date('d.m.Y H:i:s'); ?></div>
       <div class="row">
          <?= GridView::widget([
              'dataProvider' => $dataProvider,
              'filterModel' => $searchModel,
              'condensed' => true,
              'showHeader' => true,
              'filterPosition' => false,
              'columns' => [
                  [ 'class' => 'yii\grid\DataColumn',
                    'value' => 'id',
                    'options' => [ 'width' => '50px;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'Server',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return Html::a($data->Server, ['/server-view/index', 'id' => $data->id]);
                     },
                    'options' => [ 'width' => '200px;']
                  ],
/*                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'usertyp',
                    'options' => [ 'width' => '80px;'],
                  ],
*/                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'typ',
                    'options' => [ 'width' => '80px;']
                  ],
                  [ 'attribute' => 'paused',
                    'format' => 'raw',
                    'value' => function ($model, $index, $widget) {
                        return Html::checkbox('paused[]', $model->paused, ['value' => $index, 'disabled' => true]);
                    },
                    'options' => [ 'width' => '50px;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_event',
                    'format' => 'raw',
                    'value' => function ($data) { return app\controllers\ServerViewController::getStatusimage($data->stat_event, $data->id,'/server-view/index', $data->paused); },
                    'options' => [ 'width' => '50px;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_wait',
                    'format' => 'raw',
                    'value' => function ($data) { return app\controllers\ServerViewController::getWaitimage($data->stat_wait, $data->id,'/server-view/index', $data->paused); },
                    'options' => [ 'width' => '50px;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_queries',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_queries, $data->id, '/server-view/index', $data->paused);
                     },
                    'options' => [ 'width' => '20px;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_cpu',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_cpu, $data->id, '/server-view/res_cpu', $data->paused);
                     },
                    'options' => [ 'width' => '20px;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_mem',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_mem, $data->id, '/server-view/res_mem', $data->paused);
                     },
                    'options' => [ 'width' => '20px;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_disk',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_disk, $data->id, '/server-view/res_disk', $data->paused);
                     },
                    'options' => [ 'width' => '20px;']
                  ],
                  [ 'class' => 'yii\grid\DataColumn',
                    'attribute' => 'stat_sess',
                    'format' => 'raw',
                    'value' => function ($data) {
                         return app\controllers\ServerViewController::getStatusimage($data->stat_sess, $data->id, '/server-view/res_sess', $data->paused);
                     },
                    'options' => [ 'width' => '20px;']
                  ],
                   [ 'class' => 'yii\grid\DataColumn',
                      'attribute' => 'stat_net',
                      'format' => 'raw',
                      'value' => function ($data) {
                           return app\controllers\ServerViewController::getStatusimage($data->stat_net, $data->id, '/server-view/res_net', $data->paused);
                       },
                      'options' => [ 'width' => '20px;']
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
