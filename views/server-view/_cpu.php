<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
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
  <?= app\controllers\ServerViewController::getPaintLine($servername, $dataset_0, $cntrs[0], $id, 0); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_1, $cntrs[1], $id, 0); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_2, $cntrs[2], $id, 0); ?>
  <?php  echo app\controllers\ServerViewController::getPaintLine($servername, $dataset_3, $cntrs[3], $id, 0); ?>

</div>
