<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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

<h3><?php echo Html::a('Server: '.$servername, ['/server-view/index', 'id' => $id]); ?></h3>
  
<?php

$cont = $this->render('_cpu', [ 'dataset_0' => $dataset_0, 'dataset_1' => $dataset_1, 
                                'dataset_2' => $dataset_2, 'dataset_3' => $dataset_3, 'cntrs' => $cntrs, 'id' => $id,
                                   ]);  
//        \yii\helpers\VarDumper::dump($dataset_2, 10, true);

echo TabsX::widget([
    'items'=> [
        [
            'label'=>'<i class="glyphicon glyphicon-flash"></i> Cpu',
            'content'=> $cont,
            'url'=>\yii\helpers\Url::toRoute(['res_cpu', 'id' => $id]),
            'active'=>true
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
