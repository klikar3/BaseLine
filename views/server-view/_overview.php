<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use yii\widgets\ListView;
use kartik\grid\GridView;

use klikar3\rgraph\RGraphLine;
use klikar3\rgraph\RGraphBar;
/* @var $this yii\web\View */
/* @var $model app\models\ConfigData */
/* @var $form yii\widgets\ActiveForm */
if (empty($dt)) {
  date_default_timezone_set('Europe/Berlin'); 
  $dt = date('Y-m-d H:i:s',time() - 60 * 60);
}
if (empty($dtd)) {
  date_default_timezone_set('Europe/Berlin'); 
  $dtd = date('Ymd',time() - 60 * 60 * 24 * 180);
}
    ini_set('display_errors',0);


//    ini_set('max_execution_time', 1);
//    while(1) {/*nothing*/}
    // will die after 1 sec and print error

?>
<?php

    $this->registerJs(
       "var autoRefresh = setInterval( function ()
    {
       window.location.reload();
    }, 150000); // this will reload page after every 2,5 minutes.
    
    $(document).ready(function() { 
   $('a[data-toggle=\"tab\"]').on('show.bs.tab', function (e) {
      localStorage.setItem('lastTab', $(this).attr('href'));
   });
   var lastTab = localStorage.getItem('lastTab');
   if (lastTab) {
      $('[href=\"' + lastTab + '\"]').tab('show');
   }
   alert('ready');
});
alert = function (str)
{
    console.log(str);
};
    "
    );
    date_default_timezone_set('Europe/Berlin'); 
?>
<style>
    .RGraph_tooltip img {
        display: none;
    }

    .RGraph_tooltip {
        box-shadow: none ! important;
        border: 2px solid blue ! important;
        background-color: white ! important;
        padding: 3px ! important;
        text-align: center;
        font-weight: bold;
        font-family: Verdana;
    }
</style>
<?= 'Refreshed on '.date('d.m.Y H:i:s'); ?>

<div class="row">
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_as,*/ ['Instance: Active Session Count','_Total'], $id, 0, $dt, 1, 'Instance: Active Session Count'); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername,/* $datasets,*/ ['SQLServer:Buffer Manager:Page life expectancy:',''], $id, 0, $dt, 1, 'SQL: Page life expectancy'); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_cpu,*/ ['Instance: Cpu Utilization %','_Total'], $id, 0, $dt, 1, 'Cpu Utilization %'); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_pps,*/ ['OS:Pages/Sec:','_Total'], $id, 0, $dt, 1); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_dql,*/ 'OS:Disk Queue Length:_Total', $id, 0, $dt, 1); ?>
  <?php echo ($servertyp <> 'sql') ? '' : app\controllers\ServerViewController::getNetLine($servername, /*$dataset_net,*/ 'BytesTotalPersec', $id, 0); ?>
</div>
<div class="row">
  <?php echo ($servertyp <> 'sql') ? '' : app\controllers\ServerViewController::getWaitBar($servername, $dataset_waits, 'Waits', $id, 0); ?>
  <?php echo ($servertyp <> 'sql') ? '' : app\controllers\ServerViewController::getPaintLineDbSize($servername, /*$dataset_dbSizes,*/ $id, 1,$dtd); ?>
        
</div>
