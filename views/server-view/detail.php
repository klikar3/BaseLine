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
<?php

    $this->registerJs(
       '    function myClick (e)
    {
        
        alert("The onclick listener just fired " );
    }'
    );
?>

<div class="site-index">


    <div class="body-content">

<h3><?php echo 'Server: '.$servername ?></h3> <?=Html::a('Ressources',Url::toRoute(['res_cpu', 'id' => $id]));?>
  

<?= 'Refreshed on '.date('d.m.Y H:i:s'); ?>
<div class="row">
  <?php /*$test = array();
      $test = array_chunk(
          ArrayHelper::getColumn($dataset,'CaptureDate')
          ,10);
      \yii\helpers\VarDumper::dump($test, 10, true);
*/  ?>
  <?= RGraphLine::widget([
          'data' => !empty($dataset) ? array_map('intval',ArrayHelper::getColumn($dataset,'value')) : [ 0 ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'allowContext' => true,
          'options' => [
              'height' => '600px',
              'width' => '800px',
              'colors' => ['blue'],
              'filled' => true,
//              'spline' => true,
              'clearto' => ['white'],
              'labels' => !empty($dataset) ? array_map(function($val){return substr($val,1,15);},
                                    array_column(array_chunk(ArrayHelper::getColumn($dataset,'CaptureDate'),count($dataset)/10),0)
                          ) : [ 'No Data' ],
              'tooltips' => !empty($dataset) ? ArrayHelper::getColumn($dataset,'value') : [ 'No Data' ],
              'numxticks' => 10,
              'textAngle' => 45,
              'textSize' => 8,
              'gutter' => ['left' => 45, 'bottom' => 50, 'top' => 50],
              'title' => $cntr,
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'none',
              'ymax' => 100,
              'backgroundColor' => 'Gradient(red:orange:white)',
              'backgroundGridAutofitNumvlines' => 10,
              'key' => ['keyInteractive' => true],
              'contextmenu' => [
 //                 ['24h',"function () {window.location.assign('".Url::toRoute(['res_cpu','cntr' => $cntr, 'id' => $id])."');} "],
                  ['242h',"myClick('".Url::toRoute(['res_cpu','cntr' => $cntr, 'id' => $id])."');"],
              ],
          ]
  ]);
  ?>
<?php

    $this->registerJs(
       'function myClick(e)
    {
       window.location.assign(e);
    }'); 

?>

</div>
   </div>
</div>
