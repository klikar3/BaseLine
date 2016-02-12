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
  <?php /*  RGraphLine::widget([
          'data' => !empty($dataset_dql) ? array_map('floatval',ArrayHelper::getColumn($dataset_dql,'value')) : [ 0 ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'options' => [
              'width' => '225px',
              'colors' => ['blue'],
              'clearto' => ['white'],
              'labels' => !empty($dataset_dql) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset_dql,'CaptureDate')
                          ) : [ 'No Data' ],
              'tooltips' => !empty($dataset_dql) ? ArrayHelper::getColumn($dataset_dql,'value') : [ 'No Data' ],
              'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
              'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 8,
              'gutter' => ['left' => 20, 'bottom' => 50, 'top' => 50],
              'title' => 'OS: Disk Queue Length',
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'circle',
              'backgroundColor' => 'Gradient(green:lightgreen:white)',
          ]
  ]);  */
  ?>

</div>
