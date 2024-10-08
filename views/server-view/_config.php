<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;

use yii\widgets\ListView;
use kartik\grid\GridView;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConfigData */
/* @var $form yii\widgets\ActiveForm */

$dataProvider->setPagination(['pageSize' => '90']);

?>

<div class="config-data-form">
<?php  echo GridView::widget([
    'dataProvider'=> $dataProvider,
    'condensed' => true,
//    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'Name','Value','ValueInUse' /*,'CaptureDate'*/],
    'responsive'=>true,
    'hover'=>true, 
    'rowOptions'=>function ($model, $key, $index, $grid){
           return ['class'=>$index%2 ? 'normal' : 'info'];
		},
//    'pager' => [
//        'pagesize' => 15,
//    ]
//    'striped' => true,
//    'tableOptions' =>['class' => 'table table-striped table-bordered'],
]);  
?>
<?php /* ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
                return "<tr><td>".Html::a(Html::encode($model->Name), ['view', 'id' => $model->id])."</td><td>".$model->Value."</td></tr>";
        },
])*/ ?>

</div>
