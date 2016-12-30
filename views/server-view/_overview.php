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
});
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
  <?= app\controllers\ServerViewController::getPaintLine($servername, $datasets, ['Page Life Expectancy',''], $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_cpu, 'Cpu Utilization %', $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_pps, 'OS: Pages/Sec', $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_dql, 'OS:Disk Queue Length:_Total', $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getNetLine($servername, $dataset_net, 'BytesTotalPersec', $id, 0); ?>
</div>
<div class="row">
  <?php echo app\controllers\ServerViewController::getWaitBar($servername, $dataset_waits, 'Waits', $id, 0); ?>
        
</div>
