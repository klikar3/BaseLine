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

date_default_timezone_set('Europe/Berlin');
 
if (!empty($dt)) {
  $dt = date('Ymd H:i:s',time() - 60 * 60);
}
?>
<?php echo app\controllers\ServerViewController::getCss(); ?>

<?= 'Refreshed on '.date('d.m.Y H:i:s'); ?>
<div class="row">
  <?= app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_0,*/ $cntrs[0], $id, 0, $dt, 1, "SQL: Page Life Expectancy"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_1,*/  $cntrs[1], $id, 0, $dt, 1, "OS: Memory Utilization %"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_2,*/  $cntrs[2], $id, 0, $dt, 1, "Instance: PlanCacheSize(MB)"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_3,*/  $cntrs[3], $id, 0, $dt, 1, "SQL: Buffer Cache Hit Ratio"); ?>
  <?php  //echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_5, $cntrs[5], $id, 0, "SQL: Procedure Cache Hit Ratio"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_6,*/  $cntrs[6], $id, 0, $dt, 1, "OS: Memory Paging (Pages/Sec)"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_13,*/  $cntrs[13], $id, 0, $dt, 1, "BufMangr: Page Reads/Sec"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_14,*/  $cntrs[14], $id, 0, $dt, 1, "BufMangr: Page Writes/Sec"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_7,*/  $cntrs[7], $id, 0, $dt, 1, "SQL: Log Bytes Flushed/Sec"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_8,*/  $cntrs[8], $id, 0, $dt, 1, "SQL: Log Flushes/sec"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_9,*/  $cntrs[9], $id, 0, $dt, 1, "SQL: SQL Compilations/Sec"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_10,*/  $cntrs[10], $id, 0, $dt, 1, "SQL: SQL Re-Compilations/Sec"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_11,*/  $cntrs[11], $id, 0, $dt, 1,  "SQL: Plan Cache Hit Ratio"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_12,*/  $cntrs[12], $id, 0, $dt, 1,  "SQL: MemManagr.: Server Memory(KB)"); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, /*$dataset_4,*/  $cntrs[4], $id, 0, $dt, 1, "Instance: BufferCacheSize (MB)"); ?>

</div>
