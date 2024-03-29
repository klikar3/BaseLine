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
echo Html::button($servername.'&nbsp;<span class="caret"></span>', 
    ['type'=>'button', 'class'=>'btn btn-default', 'data-toggle'=>'dropdown']);
echo DropdownX::widget([ 'items' => $items,]); 

?></h4> <?php echo Html::endTag('div'); ?>
<?php echo Html::beginTag('div', ['style'=>'text-align: right;']); 
echo Html::a('Ressourcen',Url::toRoute(['res_cpu', 'id' => $id])); 
echo Html::endTag('div');
?>  
<?php

$overview = $this->render('_overview', ['id' => $id,
                                        'servername' => $servername,
                                        'datasets' => $datasets,
                                        'dataset_as' => $dataset_as,
                                        'dataset_cpu' => $dataset_cpu,
                                        'dataset_pps' => $dataset_pps,
                                        'dataset_dql' => $dataset_dql,
                                        'dataset_net' => $dataset_net,
                                        'dataset_waits' => $dataset_waits
                                        , 'dataset_dbSizes' => $dataset_dbSizes
                                        ]);  
$content1 = $this->render('_config', ['servername' => $servername,
                                                  'dataProvider' => $dataProvider]);
$content_sc = $this->render('_sconfig', ['servername' => $servername,
                                                  'dataProvider_sc' => $dataProvider_sc]);
$content_db = $this->render('_dbconfig', ['servername' => $servername,
                                                  'dataProvider_db' => $dataProvider_db]);
$content_event = $this->render('_eventLog', ['servername' => $servername,
                                                  'dataProvider_event' => $dataProvider_event]);
                                                  

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
            'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Datenbanken',
            'content'=>$content_db
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Eventlog',
            'content'=>$content_event
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Weiteres',
            'items'=>[
                 [
                     'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Option 2',
                     'encode'=>false,
                    'content'=>'',
                 ],
                [
                    'label'=>'<i class="glyphicon glyphicon-king"></i> Disabled',
                    'encode'=>false,
                    'content'=>'',
                    'headerOptions' => ['class'=>'disabled'],
                ],
            ],
        ],
    ],
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);

?>
    </div>
</div>
