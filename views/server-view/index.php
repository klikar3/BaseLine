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
$items = app\controllers\ServerViewController::getServersMenu("/index.php?r=server-view%2Findex&id=",$id);
?>
<div class="site-index">


    <div class="body-content">
<?php echo Html::beginTag('div', ['class'=>'dropdown']); ?>
<h4>Server:&nbsp; <?php
echo Html::button($servername.'&nbsp;<span class="caret"></span></button>', 
    ['type'=>'button', 'class'=>'btn btn-default', 'data-toggle'=>'dropdown']);
echo DropdownX::widget([ 'items' => $items,]); 
echo Html::endTag('div');
?></h4> 
<?php echo Html::beginTag('div', ['style'=>'text-align: right;']); 
echo Html::a('Ressourcen',Url::toRoute(['res_cpu', 'id' => $id])); 
echo Html::endTag('div');
?>  
<?php

$overview = $this->render('_overview', ['id' => $id,
                                        'servername' => $servername,
                                        'datasets' => $datasets,
                                        'dataset_cpu' => $dataset_cpu,
                                        'dataset_pps' => $dataset_pps,
                                        'dataset_dql' => $dataset_dql]);  
$content1 = $this->render('_config', ['servername' => $servername,
                                                  'dataProvider' => $dataProvider]);
$content_sc = $this->render('_sconfig', ['servername' => $servername,
                                                  'dataProvider_sc' => $dataProvider_sc]);
                                                  

echo TabsX::widget([
    'items'=> [
        [
            'label'=>'<i class="glyphicon glyphicon-home"></i> &Uuml;bersicht',
            'content'=> $overview,
            'active'=>true
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-user"></i> SQL-Konfiguration',
            'content'=>$content1
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-user"></i> Server-Konfiguration',
            'content'=>$content_sc
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Dropdown',
            'items'=>[
                 [
                     'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Option 1',
                     'encode'=>false,
                     'content'=>$content1,
                 ],
                 [
                     'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Option 2',
                     'encode'=>false,
                     'content'=>$content1,
                 ],
            ],
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-king"></i> Disabled',
            'headerOptions' => ['class'=>'disabled']
        ],
    ],
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);

?>
    </div>
</div>
