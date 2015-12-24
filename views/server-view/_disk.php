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
  <?= RGraphLine::widget([
          'data' => !empty($datasets) ? array_map('intval',ArrayHelper::getColumn($datasets,'value')) : [ 0 ],
          'allowDynamic' => true,
          'allowTooltips' => true,
/*          'allowZoom' => true,
          'allowContext' => true,
          'allowAnnotate' => true,
          'allowAdjusting' => true,
*/          'options' => [
//              'height' => '100px',
              'width' => '225px',
              'colors' => ['blue'],
//              'spline' => true,
              'clearto' => ['white'],
              'labels' => !empty($datasets) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($datasets,'CaptureDate')
                          ) : [ 'No Data' ],
              'tooltips' => !empty($datasets) ? ArrayHelper::getColumn($datasets,'value') : [ 'No Data' ],
//              'numxticks' => 10,
              'textAngle' => 45,
              'textSize' => 8,
              'gutter' => ['left' => 45, 'bottom' => 50, 'top' => 50],
//              'key' => ['Page Life Expectancy'],
//              'contextmenu' => '["Zoom in", RGraph.Zoom]',
              'title' => 'Page Life Expectancy',
              'titleSize' => 12,
              'titleBold' => false,
//              'annotatable' => true,
              'tickmarks' => 'circle',
              'backgroundColor' => 'Gradient(red:orange:white)',
          ]
  ]);
  ?>
  <?=  RGraphLine::widget([
          'data' => !empty($dataset_cpu) ? array_map('floatval',ArrayHelper::getColumn($dataset_cpu,'value')) : [ 0 ],
          'allowDynamic' => true,
          'allowTooltips' => true,//          'link' => Url::to(['/test']),
          'options' => [
//              'height' => '100px',
              'width' => '225px',
              'colors' => ['blue'],
//              'filled' => true,
              'clearto' => ['white'],
              'labels' => !empty($dataset_cpu) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset_cpu,'CaptureDate')
                          ) : [ 'No Data' ],
              'tooltips' => !empty($dataset_cpu) ? ArrayHelper::getColumn($dataset_cpu,'value') : [ 'No Data' ],
//              'tooltips' => ['Link:<a href=\''.Url::to(['/test']).'\'>aaa</a>'],
              'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
              'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 8,
              'gutter' => ['left' => 20, 'bottom' => 50, 'top' => 50],
              'title' => 'OS: Cpu Utilization %',
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'circle',
              'ymax' => 100,
              'backgroundColor' => 'Gradient(green:lightgreen:white)',
          ]
  ]);
  ?>
  <?=  RGraphLine::widget([
          'data' => !empty($dataset_pps) ? array_map('floatval',ArrayHelper::getColumn($dataset_pps,'value')) : [ 0 ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'options' => [
              'width' => '225px',
              'colors' => ['blue'],
              'clearto' => ['white'],
              'labels' => !empty($dataset_pps) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset_pps,'CaptureDate')
                          ) : [ 'No Data' ],
              'tooltips' => !empty($dataset_pps) ? ArrayHelper::getColumn($dataset_pps,'value') : [ 'No Data' ],
              'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
              'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 8,
              'gutter' => ['left' => 20, 'bottom' => 50, 'top' => 50],
              'title' => 'OS: Pages/Sec',
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'circle',
              'backgroundColor' => 'Gradient(green:lightgreen:white)',
          ]
  ]);
  ?>
  <?=  RGraphLine::widget([
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
  ]);
  ?>

</div>
