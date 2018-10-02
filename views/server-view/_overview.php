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
    ini_set('display_errors',0);

//    register_shutdown_function('shutdown1');

    function shutdown1() 
    { 
      if (0==1) {
        print '<meta http-equiv="refresh" content="0; url=/index.php?r=server-view%2Findex&id=<?=$id?>">';
        // just do a meta refresh. Haven't tested with header location, but
        // this works fine.
      }
         if(!is_null($e = error_get_last()))
        {
          header('content-type: text/plain');
          print "this is not html:\n\n". print_r($e,true);
        }
   }
    
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
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $datasets, ['Page Life Expectancy',''], $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_cpu, 'Cpu Utilization %', $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_pps, 'OS: Pages/Sec', $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_dql, 'OS:Disk Queue Length:_Total', $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getNetLine($servername, $dataset_net, 'BytesTotalPersec', $id, 0); ?>
</div>
<div class="row">
  <?php echo app\controllers\ServerViewController::getWaitBar($servername, $dataset_waits, 'Waits', $id, 0); ?>
        
</div>
