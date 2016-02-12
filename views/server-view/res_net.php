<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

use kartik\dropdown\DropdownX;
use kartik\grid\GridView;
use kartik\tabs\TabsX;

//use robregonm\rgraph\RGraphBarAsset;
//use app\assets\RGraphBarAsset;
use klikar3\rgraph\RGraph;
use klikar3\rgraph\RGraphBar;


//RGraphBar::register($this);

/* @var $this yii\web\View */

$this->title = 'BaseLine';
$items = app\controllers\ServerViewController::getServersMenu("/index.php?r=server-view%2Fres_net&id=",$id);

?>
<div class="site-index">


    <div class="body-content">
<?php echo Html::beginTag('div', ['class'=>'dropdown']); ?>
<h4>Server:&nbsp; <?php
echo Html::button($servername.'&nbsp;<span class="caret"></span></button>', 
    ['type'=>'button', 'class'=>'btn btn-default', 'data-toggle'=>'dropdown']);
echo DropdownX::widget([ 'items' => $items,]); 
echo Html::endTag('div');
?> </h4>
<?php echo Html::beginTag('div', ['style'=>'text-align: right;']); 
echo Html::a('&Uuml;bersicht',Url::toRoute(['/server-view/index', 'id' => $id])); 
echo Html::endTag('div');
?><?php

$cont_cpu = $this->render('_net', [ 'dataset_cpu' => $dataset_cpu, 'cntrs' => $cntrs, 'id' => $id,
                                   ]);  

echo TabsX::widget([
    'items'=> [
        [
            'label'=>'<i class="glyphicon glyphicon-flash"></i> Cpu',
            'content'=> $cont_cpu,
            'url'=>\yii\helpers\Url::toRoute(['res_cpu', 'id' => $id]),
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-oil"></i> Memory',
            'content'=>'',
            'url'=>\yii\helpers\Url::toRoute(['res_mem', 'id' => $id]),
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-floppy-disk"></i> Disk',
            'content'=>'',
            'url'=>\yii\helpers\Url::toRoute(['res_disk', 'id' => $id]),
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-transfer"></i> Network',
            'content'=>'',
            'url'=>\yii\helpers\Url::toRoute(['res_net', 'id' => $id]),
            'active'=>true
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-king"></i> Sessions',
            'content'=>'',
            'url'=>\yii\helpers\Url::toRoute(['res_sess', 'id' => $id]),
//            'headerOptions' => ['class'=>'disabled']
        ],
    ],
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);

?>
    </div>
</div>
