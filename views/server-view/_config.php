<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\widgets\ListView;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\ConfigData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-data-form">
<?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'condensed' => true,
//    'filterModel' => $searchModel,
    'columns' => ['Name','Value','ValueInUse','CaptureDate'],
    'responsive'=>true,
    'hover'=>true
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
