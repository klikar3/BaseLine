<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;

use kartik\detail\DetailView;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model app\models\ServerData */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="server-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'Server',
            'usertyp',
            'usr',
            [
                'attribute'=>'pwd', 
//                'label'=>'Available?',
                'format'=>'raw',
                'value'=>'<span class="label label-danger">N/A</span>',
                'type'=>DetailView::INPUT_PASSWORD,
//                'widgetOptions' => [
//                    'pluginOptions' => [
//                        'onText' => 'Yes',
//                        'offText' => 'No',
//                    ]
//                ],
//                'valueColOptions'=>['style'=>'width:30%']
            ],
//            'pwd',
            'snmp_pw',
            'typ',
            'paused',
            'stat_wait',
            'stat_queries',
            'stat_cpu',
            'stat_mem',
            'stat_disk',
            'stat_sess',
        ],
    ]) ?>

</div>
