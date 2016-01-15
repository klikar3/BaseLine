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
    
    var go = function go(where) {
      window.location.assign(where);
    }
    '
    );
    date_default_timezone_set('Europe/Berlin'); 

?>
<?= 'Refreshed on '.date('d.m.Y H:i:s'); ?>
<div class="row">
  <a href="<?= Url::toRoute(['detail','cntr' => $cntrs[0], 'id' => $id])?>">
  <?= app\controllers\ServerViewController::getPaintLine($dataset_0, $cntrs[0], $id); ?>
  </a>
  <?= app\controllers\ServerViewController::getPaintLine($dataset_1, $cntrs[1], $id); ?>
  <?=  app\controllers\ServerViewController::getPaintLine($dataset_2, $cntrs[2], $id);  ?>
  <?=  app\controllers\ServerViewController::getPaintLine($dataset_3, $cntrs[3], $id);  ?>

</div>
