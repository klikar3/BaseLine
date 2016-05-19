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
  <?php echo app\controllers\ServerViewController::getNetLine($servername, $dataset_0, $cntrs[0], $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getNetLine($servername, $dataset_1, $cntrs[1], $id, 0); ?>
  <?php echo app\controllers\ServerViewController::getNetLine($servername, $dataset_2, $cntrs[2], $id, 0); ?>

</div>
