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
       'var autoRefresh = setInterval( function ()
    {
       window.location.reload();
    }, 60000); // this will reload page after every 1 minute.
    '
    );
    date_default_timezone_set('Europe/Berlin'); 

?>
<?= 'Refreshed on '.date('d.m.Y H:i:s'); ?>
<div class="row">
  <?= app\controllers\ServerViewController::getPaintLine($servername, $datasets, ['Page Life Expectancy',''], $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_cpu, 'Cpu Utilization %', $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_pps, 'Pages/Sec', $id, 0); ?>
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_dql, 'Disk Queue Length', $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getNetLine($servername, $dataset_net, 'BytesTotalPersec', $id, 0); ?>

</div>
