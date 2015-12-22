<?php

use yii\helpers\Html;
use kartik\grid\GridView;


//use robregonm\rgraph\RGraphBarAsset;
//use app\assets\RGraphBarAsset;
use klikar3\rgraph\RGraph;
use klikar3\rgraph\RGraphBar;


//RGraphBar::register($this);

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
       <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

				<?= 
				   RGraphBar::widget([
					    'data' => [1, 3, 5, 7, 2, 4, 6, 10, 8, 9, 12, 11],
					    'options' => [
        'height' => 400,
        'width' => 800,
					        'chart' => [
					            'gutter' => [
					                'left' => 35,
					            ],
					            'colors' => ['red'],
					            'title' => 'A basic chart',
					            'labels' => [
					                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
					            ],
					        ]
					    ]
					]);
				?>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p></p>

            </div>
        </div>

    </div>
</div>
