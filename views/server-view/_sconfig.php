<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\widgets\ListView;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\ConfigData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sconfig-data-form">
<?= GridView::widget([
    'dataProvider'=> $dataProvider_sc,
    'condensed' => true,
//    'filterModel' => $searchModel,
    'columns' => ['Server','Property','Value','CaptureDate'],
    'responsive'=>true,
    'hover'=>true,
    'rowOptions'=>function ($model, $key, $index, $grid){
           return ['class'=>$index%2 ? 'normal' : 'info'];
		},
]);
?>

</div>
