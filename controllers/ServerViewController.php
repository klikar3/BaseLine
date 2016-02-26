<?php

namespace app\controllers;

//use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

use klikar3\rgraph\RGraphLine;

use app\models\ConfigData;
use app\models\ConfigDataSearch;
use app\models\ServerConfig;
use app\models\ServerData;

class ServerViewController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $connection = \Yii::$app->db;        
        $servername = $this->getServername($id);
          
        $cmd = $connection
      	       ->createCommand('SELECT MAX([CaptureDate]) FROM ConfigData WHERE [Server]=:srv');
        $cmd->bindValue(':srv', $servername);
        $datum = $cmd->queryScalar(); 
        
//        $searchModel = new ConfigDataSearch();
//        $dataProvider = $searchModel->search(['ConfigDataSearch'=>['server'=>$servername]]);
        $dataProvider = new ActiveDataProvider([
//            'query' => $query->select('server')->from('ConfigData')->andFilterWhere([
//                        'server' => $servername]),
            'query' => ConfigData::find()->where(['Server' => $servername])->andWhere(['CaptureDate' => $datum]),
//            'pagination' => [
//                'pageSize' => 20,
//            ],
        ]);
        // get the posts in the current page
        $posts = $dataProvider->getModels();
//        \yii\helpers\VarDumper::dump($dataProvider, 10, true);

        // -- ServerConfig
        $cmd = $connection
      	       ->createCommand('SELECT MAX([CaptureDate]) FROM ServerConfig WHERE [server]=:srv');
        $cmd->bindValue(':srv', $servername);
        $datum = $cmd->queryScalar(); 
        $dataProvider_sc = new ActiveDataProvider([
            'query' => ServerConfig::find()->where(['Server' => $servername])->andWhere(['CaptureDate' => $datum]),
        ]);
        $posts_sc = $dataProvider_sc->getModels();

        // -- Datasets
        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
//        $dt->modify('-1 hour');
//        \yii\helpers\VarDumper::dump($datasets, 10, true);
          
        return $this->render('index', [
            'id' => $id,
            'servername' => $servername,
            'dataProvider' => $dataProvider,
            'dataProvider_sc' => $dataProvider_sc,
            'datasets' => $this->getPerfmonDataset($servername,['Page Life Expectancy',''], $dt ),
            'dataset_cpu' => $this->getPerfmonDataset($servername,'Cpu Utilization %',$dt),
            'dataset_pps' => $this->getPerfmonDataset($servername,'Pages/sec', $dt ),
            'dataset_dql' => $this->getPerfmonDataset($servername,'Disk Queue Length', $dt ),
        ]);
    }

    public function actionRes_cpu($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => 'Signal Wait Percent',1 => 'Cpu Utilization %', 2 => 'Cpu Usage %', 3 => 'Cpu Queue Length');

//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('res_cpu', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_0' => $this->getPerfmonDataset($servername,$cntrs[0],$dt),
            'dataset_1' => $this->getPerfmonDataset($servername,$cntrs[1],$dt),
            'dataset_2' => $this->getPerfmonDataset($servername,$cntrs[2],$dt),
            'dataset_3' => $this->getPerfmonDataset($servername,$cntrs[3],$dt),
        ]);
    }

    public function actionRes_mem($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => ['Page Life Expectancy',''],1 => ['Memory Utilization %','_Total'], 
                        2 => ['Plan Cache Size (MB)','_Total'], 3 => ['Buffer cache hit ratio',''], 
                        4 => 'Buffer Cache Size (MB)', 5 => ['Cache Hit Ratio','_Total'],
                        6 => 'Pages/Sec', 7 => 'Log Bytes Flushed/sec',
                        8 => 'Log Flushes/sec', 9 => ['SQL Compilations/sec',''],
                        10 => ['SQL Re-Compilations/sec',''], 11 => '',
                        );

//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('res_mem', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_0' => $this->getPerfmonDataset($servername,$cntrs[0],$dt),
            'dataset_1' => $this->getPerfmonDataset($servername,$cntrs[1],$dt),
            'dataset_2' => $this->getPerfmonDataset($servername,$cntrs[2],$dt),
            'dataset_3' => $this->getPerfmonDataset($servername,$cntrs[3],$dt),
            'dataset_4' => $this->getPerfmonDataset($servername,$cntrs[4],$dt),
            'dataset_5' => $this->getPerfmonDataset($servername,$cntrs[5],$dt),
            'dataset_6' => $this->getPerfmonDataset($servername,$cntrs[6],$dt),
            'dataset_7' => $this->getPerfmonDataset($servername,$cntrs[7],$dt),
            'dataset_8' => $this->getPerfmonDataset($servername,$cntrs[8],$dt),
            'dataset_9' => $this->getPerfmonDataset($servername,$cntrs[9],$dt),
            'dataset_10' => $this->getPerfmonDataset($servername,$cntrs[10],$dt),
            'dataset_11' => $this->getPerfmonDataset($servername,$cntrs[11],$dt),
        ]);
    }

    public function actionRes_disk($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => 'I/O Wait Time',1 => 'I/O Read Wait Time', 2 => 'I/O Write Wait Time', 3 => 'Disk Queue Length',
                        4 => 'Physical I/O Rate (Kb/sec)', 5 => 'Physical Read I/O Rate (Kb/sec)', 
                        6 => 'Physical Write I/O Rate (Kb/sec)', 7 => 'Physical Transfers Per Sec');

        return $this->render('res_disk', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_0' => $this->getPerfmonDataset($servername,$cntrs[0],$dt),
            'dataset_1' => $this->getPerfmonDataset($servername,$cntrs[1],$dt),
            'dataset_2' => $this->getPerfmonDataset($servername,$cntrs[2],$dt),
            'dataset_3' => $this->getPerfmonDataset($servername,$cntrs[3],$dt),
            'dataset_4' => $this->getPerfmonDataset($servername,$cntrs[4],$dt),
            'dataset_5' => $this->getPerfmonDataset($servername,$cntrs[5],$dt),
            'dataset_6' => $this->getPerfmonDataset($servername,$cntrs[6],$dt),
            'dataset_7' => $this->getPerfmonDataset($servername,$cntrs[7],$dt),
/*            'dataset_8' => $this->getPerfmonDataset($servername,$cntrs[8],$dt),
            'dataset_9' => $this->getPerfmonDataset($servername,$cntrs[9],$dt),
            'dataset_10' => $this->getPerfmonDataset($servername,$cntrs[10],$dt),
            'dataset_11' => $this->getPerfmonDataset($servername,$cntrs[11],$dt),
*/        ]);
    }

    public function actionRes_net($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => '',1 => 'Cpu Utilization %', 2 => '', 3 => '');

//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('res_net', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_cpu' => $this->getPerfmonDataset($servername,$cntrs[1],$dt),
        ]);
    }

    public function actionRes_sess($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => '',1 => 'Cpu Utilization %', 2 => '', 3 => '');

//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('res_sess', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_cpu' => $this->getPerfmonDataset($servername,$cntrs[1],$dt),
        ]);
    }

    public function actionDetail($cntr,$id,$days)
    {
        $cntr = json_decode($cntr);
        $servername = $this->getServername($id);

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * $days);

        return $this->render('detail', [
            'id' => $id,
            'cntr' => $cntr,
            'servername' => $servername,
            'dataset' => $this->getPerfmonDataset($servername,$cntr,$dt),
        ]);
    }
    
    public static function getServername($id)
    {
        $lconn = \Yii::$app->db;        
        $cmd = $lconn
              	->createCommand('SELECT [Server] FROM ServerData WHERE id=:id');
        $cmd->bindValue(':id', $id);
        $servername = $cmd->queryScalar();
        
        return $servername;

    }

    public function getPerfmonDataset($srvr,$cntr,$dt)
    {
        $instance='_Total';
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
        $pcid = (new \yii\db\Query())
        ->select('id')->from('PerfCounterDefault')->where('counter_name=:cntr', array('cntr' => $counter))
        ->scalar();
        
        $dataset = (new \yii\db\Query())
        ->select('value, AvgValue, CaptureDate')->from('PerfMonData')->where('Server=:srvr AND Counter_id=:pcid AND CaptureDate>:dt AND instance=:inst',
        array('srvr' => $srvr, 'pcid' => $pcid, 'dt' => $dt, 'inst' => $instance ))
        ->orderBy('CaptureDate')
        ->all();
//        \yii\helpers\VarDumper::dump($dataset, 10, true);
        
        return !empty($dataset) ? $dataset : [ [0, 0] ];

    }

    public static function getStatusimage ($status,$id,$ziel) {
//        \yii\helpers\VarDumper::dump($status, 10, true);
        switch ($status) {
          case 'unknown':
              return Html::a(Html::img('@web/images/alarm_unknown.png', ['alt' => 'unknown']), [$ziel, 'id' => $id]);
          case 'green':
              return Html::a(Html::img('@web/images/check_16.png', ['alt' => 'green']), [$ziel, 'id' => $id]);
          case 'yellow':
              return Html::a(Html::img('@web/images/warning_16.png', ['alt' => 'yellow']), [$ziel, 'id' => $id]);
          case 'red':
              return Html::a(Html::img('@web/images/delete_angled_16.png', ['alt' => 'red']), [$ziel, 'id' => $id]);
        }
        return Html::a(Html::img('@web/images/delete_angled_16.png', ['alt' => 'red']), [$ziel, 'id' => $id]);
   }
   
    public static function getWaitimage ($status,$id,$ziel) {
//        \yii\helpers\VarDumper::dump($status, 10, true);
        switch ($status) {
          case 'unknown':
              return Html::a(Html::img('@web/images/WaitTimeMeter_3.png', ['alt' => 'unknown']), [$ziel, 'id' => $id]);
          case 'green':
              return Html::a(Html::img('@web/images/WaitTimeMeter_3.png', ['alt' => 'green']), [$ziel, 'id' => $id]);
          case 'yellow':
              return Html::a(Html::img('@web/images/WaitTimeMeter_3.png', ['alt' => 'yellow']), [$ziel, 'id' => $id]);
          case 'red':
              return Html::a(Html::img('@web/images/WaitTimeMeter_3.png', ['alt' => 'red']), [$ziel, 'id' => $id]);
        }
        return Html::a(Html::img('@web/images/WaitTimeMeter_3.png', ['alt' => 'red']), [$ziel, 'id' => $id]);
   }

    public static function getPaintLine($srvr,$dataset,$cntr,$id,$detail=0,$title='') {
        
        $output = true;
        
        $instance='_Total';
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
        $pcid = (new \yii\db\Query())
        ->select('id')->from('PerfCounterDefault')->where('counter_name=:cntr', ['cntr' => $counter])
        ->scalar();
        
        $pcsid = (new \yii\db\Query())
        ->select('id')->from('PerfCounterPerServer')->where('Server=:srvr AND counter_name=:cntr AND instance = :inst', 
          ['srvr' => $srvr, 'cntr' => $counter, 'inst' => $instance])
        ->scalar();
        
        $stat = 'unknown';        
        if (!empty($pcid)) $stat = (new \yii\db\Query())->select('status')->from('PerfMonData')
        ->where('Server=:srvr AND Counter_id=:pcid AND instance=:inst', array('srvr' => $srvr, 'pcid' => $pcid, 'inst' => $instance ))
        ->orderBy('CaptureDate desc')->limit(1)->scalar();

        switch ($stat) {
          case 'unknown':
              $bg = 'Gradient(lightgrey:white)'; break;
          case 'green':
              $bg = 'Gradient(lightgreen:white)'; break;
          case 'yellow':
              $bg = 'Gradient(yellow:white)'; break;
          case 'red':
              $bg = 'Gradient(orange:white)'; break;
          default:
              $bg = 'Gradient(lightgrey:white)';
       }
//      \yii\helpers\VarDumper::dump($dataset, 10, true);
      if (empty($dataset)) return '';
      $values = ArrayHelper::getColumn($dataset,'value');
      $avgvals = ArrayHelper::getColumn($dataset,'AvgValue');
      $zeiten = ArrayHelper::getColumn($dataset,'CaptureDate');
      $anzahl = (count($zeiten)>10) ? count($zeiten)/10 : count($zeiten);
      $daten = [$values, $avgvals];     
//      \yii\helpers\VarDumper::dump('Counter: '.$counter, 10, true);
        
      if ($output) return RGraphLine::widget([
          'data' => !empty($daten) ? $daten : [ [0,0] ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'allowContext' => true,
          'options' => [
              'height' => ($detail==0) ? '180px' : '500px',
              'width' => ($detail==0) ? '280px' : '800px',
              'colors' => ['blue','green'],
//              'filled' => true,
              'clearto' => ['white'],
/*              'labels' => !empty($dataset) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset,'CaptureDate')
                          ) : [ 'No Data' ],
*/             'labels' => !empty($dataset) ? array_map(function($val) use ($detail){return substr($val,0,16);},
                                    array_column(array_chunk(ArrayHelper::getColumn($dataset,'CaptureDate'),$anzahl),0)
                          ) : [ 'No Data' ],
              'tooltips' => !empty($dataset) ? array_map('strval',ArrayHelper::getColumn($dataset,'value')) : [ 'No Data' ],
//              'tooltips' => ['Link:<a href=\''.Url::to(['/test']).'\'>aaa</a>'],
  //            'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
  //            'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 8,
//              'gutter' => ['left' => 50, 'bottom' => 80, 'top' => 50],
              'gutter' => ['left' => ($detail==0) ? 50 : 50, 'bottom' => ($detail==0) ? 50 : 80, 'top' => 50],
              'title' => !empty($title) ? $title : $counter,
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'circle',
//              'ymax' => 100,
              'backgroundColor' => $bg,
              'contextmenu' => [
                  ['24h', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 1 ])."\");}") ],
                  ['7 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 7 ])."\");}") ],
                  ['32 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 32 ])."\");}") ],
                  ['1 year', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 366 ])."\");}") ],
                  ['All', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 9999 ])."\");}") ],
                  ['Setting', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['perf-counter-per-server/update','id' => $pcsid ])."\");}") ],
              ],
          ]
      ]) //."<li>". Html::a('Settings', ['perf-counter-per-server/update', 'id' => $pcsid], ['class' => 'profile-link'])."</div>"
      ;    
  }
  
    public static function getServersMenu($target,$id) {
              
        $dataset1 = (new \yii\db\Query())
        ->select('Server as label, id as url')->from('ServerData')->orderBy('id')
        ->all(); 
        
        $items = array_map(function($srv) use ($target,$id) {
                            $srv['url'] = $target.$srv['url'];
                            return $srv;} ,$dataset1);
//        \yii\helpers\VarDumper::dump($items, 10, true);

        return $items;
    }
}
