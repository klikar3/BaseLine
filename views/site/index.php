<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'BaseLine';
?>
<div class="site-index">


    <div class="body-content">
       <div class="row">
          <?= GridView::widget([
              'dataProvider' => $dataProvider,
              'filterModel' => $searchModel,
              'condensed' => true,
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
                  'usertyp',
                  [ 'class' => 'yii\grid\ActionColumn',
                    'options' => [ 'width' => '80px;']
                  ],
              ],
          ]); ?>
       </div>
     </div>
</div>
