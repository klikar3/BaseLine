<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

use kartik\grid\GridView;
use kartik\tabs\TabsX;


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

<h3><?php echo 'Server: '.$servername ?></h3> <?=Html::a('Ressources',Url::toRoute(['res_cpu', 'id' => $id]));?>
  
<?php

$overview = $this->render('_overview', ['datasets' => $datasets,
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
