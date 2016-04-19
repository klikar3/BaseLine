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
use klikar3\rgraph\RGraphLine;


//RGraphBar::register($this);

/* @var $this yii\web\View */

$this->title = 'BaseLine';


?>

<div class="site-index">


    <div class="body-content">

<h3><?php echo 'Server: '.$servername ?></h3> 
<?php echo Html::beginTag('div', ['style'=>'text-align: right;']); 
echo Html::a('Ressourcen',Url::toRoute(['res_cpu', 'id' => $id])); 
echo Html::endTag('div');
?>
<?= 'Refreshed on '.date('d.m.Y H:i:s'); ?>
<div class="row">
  <?php /*$test = array();
      $test = array_chunk(
          ArrayHelper::getColumn($dataset,'CaptureDate')
          ,10);
      \yii\helpers\VarDumper::dump($test, 10, true);
*/  ?>
  <?=  app\controllers\ServerViewController::getNetLine($servername, $dataset, $cntr, $id, 1);  ?>

</div>
   </div>
</div>
