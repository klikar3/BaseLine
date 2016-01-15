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

class ServerViewController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
//        $query = new Query;

  

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
        $datasets = (new \yii\db\Query())
          ->select('value, CaptureDate')->from('PerfMonData')->where('Server=:srvr AND Counter like :cntr AND CaptureDate>:dt',
          array('srvr' => $servername, 'cntr' => '%:Buffer Manager:Page life expectancy:', 'dt' => $dt ))
          ->all();
//        \yii\helpers\VarDumper::dump($datasets, 10, true);
        $dataset_cpu = $this->getPerfmonDataset($servername,'Cpu Utilization %',$dt);
//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);
        $dataset_pps = $this->getPerfmonDataset($servername,'Pages/sec', $dt );
//        \yii\helpers\VarDumper::dump($dataset_pps, 10, true);
        $dataset_dql = $this->getPerfmonDataset($servername,'Disk Queue Length', $dt );
//        \yii\helpers\VarDumper::dump($dataset_pps, 10, true);
        
        
          
        return $this->render('index', [
            'id' => $id,
            'servername' => $servername,
            'dataProvider' => $dataProvider,
            'dataProvider_sc' => $dataProvider_sc,
            'datasets' => $datasets,
            'dataset_cpu' => $dataset_cpu,
            'dataset_pps' => $dataset_pps,
            'dataset_dql' => $dataset_dql,
            
//            'searchModel' => $searchModel,
        ]);
    }

    public function actionRes_cpu($id)
    {

        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => '',1 => 'Cpu Utilization %', 2 => 'CPU Queue Length', 3 => '');

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
        $cntrs = array( 0 => '',1 => 'Cpu Utilization %', 2 => '', 3 => '');

//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('res_mem', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_1' => $this->getPerfmonDataset($servername,$cntrs[1],$dt),
//            'dataset_pps' => $dataset_pps,
//            'dataset_dql' => $dataset_dql,
        ]);
    }

    public function actionRes_disk($id)
    {

        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => '',1 => 'Cpu Utilization %', 2 => '', 3 => '');

//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('res_disk', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_cpu' => $this->getPerfmonDataset($servername,$cntrs[1],$dt),
//            'dataset_pps' => $dataset_pps,
//            'dataset_dql' => $dataset_dql,
        ]);
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
//            'dataset_pps' => $dataset_pps,
//            'dataset_dql' => $dataset_dql,
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
//            'dataset_pps' => $dataset_pps,
//            'dataset_dql' => $dataset_dql,
        ]);
    }

    public function actionDetail($cntr,$id,$days)
    {

        $servername = $this->getServername($id);

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * $days);
//        $dataset = $this->getPerfmonDataset($servername,$cntr,$dt);
//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('detail', [
            'id' => $id,
            'cntr' => $cntr,
            'servername' => $servername,
            'dataset' => $this->getPerfmonDataset($servername,$cntr,$dt),
//            'dataset_pps' => $dataset_pps,
//            'dataset_dql' => $dataset_dql,
        ]);
    }
    
    public function getServername($id)
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
        $pcid = (new \yii\db\Query())
        ->select('id')->from('PerfCounterDefault')->where('counter_name=:cntr', array('cntr' => $cntr))
        ->scalar();
        
        $dataset = (new \yii\db\Query())
        ->select('value, CaptureDate')->from('PerfMonData')->where('Server=:srvr AND Counter_id=:pcid AND CaptureDate>:dt',
        array('srvr' => $srvr, 'pcid' => $pcid, 'dt' => $dt ))
        ->all();
        
        return !empty($dataset) ? $dataset : [ 0 ];

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

    public static function getPaintLine($dataset,$cntr,$id) {
      return RGraphLine::widget([
          'data' => !empty($dataset) ? array_map('floatval',ArrayHelper::getColumn($dataset,'value')) : [ 0 ],
          'allowDynamic' => true,
          'allowTooltips' => true,//          'link' => Url::to(['/test']),
          'allowContext' => true,
          'options' => [
//              'height' => '100px',
              'width' => '225px',
              'colors' => ['blue'],
//              'filled' => true,
              'clearto' => ['white'],
              'labels' => !empty($dataset) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset,'CaptureDate')
                          ) : [ 'No Data' ],
              'tooltips' => !empty($dataset) ? array_map('strval',ArrayHelper::getColumn($dataset,'value')) : [ 'No Data' ],
//              'tooltips' => ['Link:<a href=\''.Url::to(['/test']).'\'>aaa</a>'],
  //            'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
  //            'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 8,
              'gutter' => ['left' => 20, 'bottom' => 50, 'top' => 50],
              'title' => $cntr,
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'circle',
//              'ymax' => 100,
              'backgroundColor' => 'Gradient(green:lightgreen:white)',
              'contextmenu' => [
                  ['24h', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => $cntr, 'id' => $id, 'days' => 1 ])."\");}") ],
                  ['7 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => $cntr, 'id' => $id, 'days' => 7 ])."\");}") ],
                  ['32 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => $cntr, 'id' => $id, 'days' => 32 ])."\");}") ],
                  ['1 year', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => $cntr, 'id' => $id, 'days' => 366 ])."\");}") ],
                  ['All', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => $cntr, 'id' => $id, 'days' => 9999 ])."\");}") ],
              ],
          ]
      ]);    
  }
}
