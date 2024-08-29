<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\widgets\ListView;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\ConfigData */
/* @var $form yii\widgets\ActiveForm */

$dataProvider_db->setPagination(['pageSize' => '90']);
//$dataProvider_db->pagination->pageSize = 90;
?>

<div class="sconfig-data-form">
<?php  echo GridView::widget([
    'dataProvider'=> $dataProvider_db,
    'condensed' => true,
//    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'db', 'Description', 'Contact', 'SLA', 'sizeMB',
//        [ 'attribute' => 'CaptureDate'  ,
//          'options' => [ 'width' => '300px;']
//        ],
     ],   
    'responsive'=>true,
    'hover'=>true,
    'rowOptions'=>function ($model, $key, $index, $grid){
           return ['class'=>$index%2 ? 'normal' : 'info'];
		},
]); 
?>

</div>
   
