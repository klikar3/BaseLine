<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use yii\widgets\ListView;
use kartik\grid\GridView;

use klikar3\rgraph\RGraphLine;

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
<?= 'Refreshed on '.date('d.m.Y H:i:s'); ?>
<div class="row">
  <?= app\controllers\ServerViewController::getPaintLine($servername, $datasets, ['Page Life Expectancy',''], $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_cpu, 'Cpu Utilization %', $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_pps, 'OS: Pages/Sec', $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_dql, 'OS:Disk Queue Length:_Total', $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getNetLine($servername, $dataset_net, 'BytesTotalPersec', $id, 0); ?>

</div>
