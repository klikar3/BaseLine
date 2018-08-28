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
<?= 'Refreshed on '.date('d.m.Y H:i:s'); ?>
<div class="row">
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_0, $cntrs[0], $id, 0, ""); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_1, $cntrs[1], $id, 0, ""); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_2, $cntrs[2], $id, 0, ""); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_3, $cntrs[3], $id, 0, "Disk Queue Length"); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_4, $cntrs[4], $id, 0, "Phys. I/O Rate (Kb/sec)"); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_5, $cntrs[5], $id, 0, "Phys. Read I/O Rate (Kb/sec)"); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_6, $cntrs[6], $id, 0, "Phys. Write I/O Rate (Kb/sec)"); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_7, $cntrs[7], $id, 0, "Phys. Transfers Per Sec"); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_8, $cntrs[8], $id, 0, "Phys. Reads Per Sec"); ?>
  <?php echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_9, $cntrs[9], $id, 0, "Phys. Writes Per Sec"); ?>
  <?php echo app\controllers\ServerViewController::getPaintLineDrives($dataset_10, $id ); ?>
  <?php // echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_11, $cntrs[11], $id, 0); ?>

</div>
