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
use klikar3\rgraph\RGraphBar;

use app\models\ConfigData;
use app\models\ConfigDataSearch;
use app\models\DbData;
use app\models\ServerConfig;
use app\models\ServerData;
use app\models\Win32EventLog;

class ServerViewController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $connection = \Yii::$app->db;        
        $servername = $this->getServername($id);
          
        $cmd = $connection
      	       ->createCommand("SELECT MAX([CaptureDate]) FROM ConfigData WHERE [Server]=:srv and Name='affinity mask';");
        $cmd->bindValue(':srv', $servername);
        $datum = $cmd->queryScalar(); 
        
//        $searchModel = new ConfigDataSearch();
//        $dataProvider = $searchModel->search(['ConfigDataSearch'=>['server'=>$servername]]);
        $dataProvider = new ActiveDataProvider([
//            'query' => $query->select('server')->from('ConfigData')->andFilterWhere([
//                        'server' => $servername]),
            'query' => ConfigData::find()->where(['Server' => $servername])->andWhere(['CaptureDate' => $datum]),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        // get the posts in the current page
////        $posts = $dataProvider->getModels();
//        \yii\helpers\VarDumper::dump($dataProvider, 10, true);

        // -- ServerConfig
        $cmd = $connection
      	       ->createCommand("SELECT MAX([CaptureDate]) FROM ServerConfig WHERE [server]=:srv AND Property = 'MachineName'");
        $cmd->bindValue(':srv', $servername);
        $datum = $cmd->queryScalar(); 
        $dataProvider_sc = new ActiveDataProvider([
            'query' => ServerConfig::find()->where(['Server' => $servername])->andWhere('CaptureDate >= :datum',[ ':datum' => $datum]),
            'pagination' => [ 'pageSize' => 15],
        ]);
////        $posts_sc = $dataProvider_sc->getModels();

        // -- Datenbank-Daten
//        $datum = DbData::find()->select(['CaptureDate'])->where(['Server' => $servername])
//                  ->orderBy(['CaptureDate' => SORT_DESC])->scalar();
        $cmd = $connection
      	       ->createCommand("SELECT MAX([CaptureDate]) FROM DBData WHERE [server]=:srv ");
        $cmd->bindValue(':srv', $servername);
        $datum = $cmd->queryScalar(); 
        $dataProvider_db = new ActiveDataProvider([
            'query' => DbData::find()->where(['Server' => $servername, 'physicalFileName' => "_Total"])->andWhere(['CaptureDate' => $datum]),
            'pagination' => [ 'pageSize' => 15],
        ]);
        $dataProvider_event = new ActiveDataProvider([
            'query' => Win32EventLog::find()->where(['ServerId' => $id])->orderBy('TimeGenerated desc')->limit(20),
            'pagination' => false,
        ]);

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
            'dataProvider_db' => $dataProvider_db,
            'dataProvider_event' => $dataProvider_event,
            'datasets' => $this->getPerfmonDataset($servername,['SQLServer:Buffer Manager:Page Life Expectancy:',''], $dt ),
            'dataset_cpu' => $this->getPerfmonDataset($servername,'Instance: Cpu Utilization %',$dt),
            'dataset_pps' => $this->getPerfmonDataset($servername,'OS:Pages/Sec:_Total', $dt ),
            'dataset_dql' => $this->getPerfmonDataset($servername,'OS:Disk Queue Length:_Total', $dt ),
            'dataset_net' => $this->getNetPerfDataset($servername,'BytesTotalPersec',$dt),
            'dataset_waits' => $this->getWaitDataset($servername,$dt),
        ]);
    }

    public function actionRes_cpu($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => 'Signal Wait Percent',1 => 'Instance: Cpu Utilization %', 2 => 'OS: Cpu Usage %', 3 => 'OS:CPU Queue Length:_Total');

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
        $cntrs = array( 0 => ['SQLServer:Buffer Manager:Page life Expectancy:',''],1 => ['OS:Memory Utilization %:_Total','_Total'], 
                        2 => ['Instance: Plan Cache Size (MB)','_Total'], 3 => ['SQLServer:Buffer Manager:Buffer cache hit ratio:',''], 
                        4 => ['Instance: Buffer Cache Size (MB)','_Total'], 5 => ['Cache Hit Ratio','_Total'],
                        6 => 'OS:Pages/Sec:_Total', 7 => 'SQLServer:Databases:Log Bytes Flushed/sec:_Total',
                        8 => 'SQLServer:Databases:Log Flushes/sec:_Total', 9 => ['SQLServer:SQL Statistics:SQL Compilations/sec:',''],
                        10 => ['SQLServer:SQL Statistics:SQL Re-Compilations/sec:',''], 11 => 'SQLServer:Plan Cache:Cache Hit Ratio:_Total',
                        12 => ['SQLServer:Memory Manager:Target Server Memory (KB):',''], 13 => ['SQLServer:Buffer Manager:Page reads/sec:',''],
                        14 => ['SQLServer:Buffer Manager:Page writes/sec:',''],
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
            'dataset_12' => $this->getPerfmonDataset($servername,$cntrs[12],$dt),
            'dataset_13' => $this->getPerfmonDataset($servername,$cntrs[13],$dt),
            'dataset_14' => $this->getPerfmonDataset($servername,$cntrs[14],$dt),
        ]);
    }

    public function actionRes_disk($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => 'I/O Wait Time',1 => 'I/O Read Wait Time', 2 => 'I/O Write Wait Time', 3 => ['OS:Disk Queue Length:_Total','_Total'],
                        4 => 'OS:Physical I/O Rate (Kb/sec):_Total', 5 => 'OS:Physical Read I/O Rate (Kb/sec):_Total', 
                        6 => 'OS:Physical Write I/O Rate (Kb/sec):_Total', 7 => 'OS:Physical Transfers Per Sec:_Total',
                        8 => 'OS:Physical Reads per Sec:_Total', 9 => 'OS:Physical Writes Per Sec:_Total',
                        );

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
            'dataset_8' => $this->getPerfmonDataset($servername,$cntrs[8],$dt),
            'dataset_9' => $this->getPerfmonDataset($servername,$cntrs[9],$dt),
            'dataset_10' => $this->getDriveDataset($servername,$id,date('Y-m-d H:i:s',time() - 60 * 60 * 24 * 1)),
/*            'dataset_11' => $this->getPerfmonDataset($servername,$cntrs[11],$dt),
*/        ]);
    }

    public function actionRes_net($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => 'BytesTotalPersec',1 => 'BytesReceivedPersec', 2 => 'BytesSentPersec');

//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('res_net', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_0' => $this->getNetPerfDataset($servername, $cntrs[0], $dt),
            'dataset_1' => $this->getNetPerfDataset($servername, $cntrs[1], $dt),
            'dataset_2' => $this->getNetPerfDataset($servername, $cntrs[2], $dt),
        ]);
    }

    public function actionRes_sess($id)
    {
        $servername = $this->getServername($id);
        $connection = \Yii::$app->db;        

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60);
        $cntrs = array( 0 => ['Instance: Active Session Count','_Total'],1 => 'SQLServer:Databases:Transactions/sec:_Total', 
                        2 => ['SQLServer:General Statistics:Processes blocked:',''], 3 => '');

//        \yii\helpers\VarDumper::dump($dataset_cpu, 10, true);

        return $this->render('res_sess', [
            'id' => $id,
            'cntrs' => $cntrs,
            'servername' => $servername,
            'dataset_0' => $this->getPerfmonDataset($servername,$cntrs[0],$dt),
            'dataset_1' => $this->getPerfmonDataset($servername,$cntrs[1],$dt),
            'dataset_2' => $this->getPerfmonDataset($servername,$cntrs[2],$dt),
            'dataset_3' => $this->getPerfmonDataset($servername,$cntrs[3],$dt),
/*            'dataset_4' => $this->getPerfmonDataset($servername,$cntrs[4],$dt),
            'dataset_5' => $this->getPerfmonDataset($servername,$cntrs[5],$dt),
            'dataset_6' => $this->getPerfmonDataset($servername,$cntrs[6],$dt),
            'dataset_7' => $this->getPerfmonDataset($servername,$cntrs[7],$dt),
            'dataset_8' => $this->getPerfmonDataset($servername,$cntrs[8],$dt),
            'dataset_9' => $this->getPerfmonDataset($servername,$cntrs[9],$dt),
            'dataset_10' => $this->getPerfmonDataset($servername,$cntrs[10],$dt),
            'dataset_11' => $this->getPerfmonDataset($servername,$cntrs[11],$dt),
*/        ]);
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
    
    public function actionDetail_net($cntr,$id,$days)
    {
        $cntr = json_decode($cntr);
        $servername = $this->getServername($id);

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * $days);

        return $this->render('detail_net', [
            'id' => $id,
            'cntr' => $cntr,
            'servername' => $servername,
            'dataset' => $this->getNetPerfDataset($servername,$cntr,$dt),
        ]);
    }
 
     public function actionDetail_disk($cntr,$id,$days)
    {
        $cntr = json_decode($cntr);
        $servername = $this->getServername($id);

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * $days);

        return $this->render('detail_disk', [
            'id' => $id,
            'cntr' => $cntr,
            'servername' => $servername,
            'dataset' => $this->getDriveDataset($servername,$id,$dt),
         ]);
    }
   
     public function actionDetail_waits($cntr,$id,$days)
    {
        $cntr = json_decode($cntr);
        $servername = $this->getServername($id);

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * $days);

        return $this->render('detail_waits', [
            'id' => $id,
            'cntr' => $cntr,
            'servername' => $servername,
            'dataset' => $this->getWaitDataset($servername,$dt),
         ]);
    }
   
    public function actionDetail_agg($cntr,$id,$days)
    {
        $cntr = json_decode($cntr);
        $servername = $this->getServername($id);

        date_default_timezone_set('Europe/Berlin'); 
        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * $days);

        return $this->render('detail_agg', [
            'id' => $id,
            'cntr' => $cntr,
            'servername' => $servername,
            'dataset' => $this->getPerfmonDatasetAgg($servername,$cntr,$dt),
        ]);
    }
    
    public function actionOver_disk($cntr='disk',$id=0,$days=7)
    {
//        $cntr = json_decode($cntr);
//        $servername = $this->getServername($id);

//        date_default_timezone_set('Europe/Berlin'); 
//        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * $days);

        return $this->render('report', [
            'id' => $id,
            'cntr' => $cntr,
            'title' => 'OS:Physical I/O Rate (Kb/sec):_Total',
            'dataset' => $this->getPerfmonDatasetRep($cntr,$days),
        ]);
    }
    
    public function actionOver_net($cntr='net',$id=0,$days=3)
    {
//        $cntr = json_decode($cntr);
//        $servername = $this->getServername($id);

//        date_default_timezone_set('Europe/Berlin'); 
//        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * $days);

        return $this->render('report', [
            'id' => $id,
            'cntr' => $cntr,
            'title' => 'BytesTotalPersec',
            'dataset' => $this->getPerfmonDatasetRep($cntr,$days),
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

    public static function getPerfCounterDefaultId($counter) 
    {
        $pcid = (new \yii\db\Query())
        ->select('id')->from('PerfCounterDefault WITH (READPAST)')->where('counter_name=:cntr', ['cntr' => $counter])
        ->scalar();
        return $pcid;
    }    
        
    public static function getPerfCounterPerServerId($srvr,$counter,$instance) 
    {    
        $pcsid = (new \yii\db\Query())
        ->select('id')->from('PerfCounterPerServer WITH (READPAST)')->where('Server=:srvr AND counter_name=:cntr AND instance = :inst', 
          ['srvr' => $srvr, 'cntr' => $counter, 'inst' => $instance])
        ->scalar();
        return $pcsid;
    }    
    
    public function getPerfmonDataset($srvr,$cntr,$dt)
    {
        $instance='_Total';
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
        $pcid = $this->getPerfCounterDefaultId($counter);
        
        $dataset = (new \yii\db\Query())
        ->select('value, AvgValue, CaptureDate')->from('PerfMonData')->where('Server=:srvr AND Counter_id=:pcid AND CaptureDate>:dt AND instance=:inst',
        array('srvr' => $srvr, 'pcid' => $pcid, 'dt' => $dt, 'inst' => $instance ))
        ->orderBy('CaptureDate')
        ->all();
//        \yii\helpers\VarDumper::dump($dataset, 10, true);
        
        return !empty($dataset) ? $dataset : [ [0, 0, ''] ];

    }

    public function getPerfmonDatasetAgg($srvr,$cntr,$dt)
    {
        $instance='_Total';
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
        $pcid = $this->getPerfCounterDefaultId($counter);
        
        $dataset = (new \yii\db\Query())
        ->select('TimeSlotStart, MinVal, AvgVal, MaxVal, Median, StdDev')->from('PerfMonDataAgg1H')->where('Server=:srvr AND Counter_id=:pcid AND TimeSlotStart>:dt AND instance=:inst',
        array('srvr' => $srvr, 'pcid' => $pcid, 'dt' => $dt, 'inst' => $instance ))
        ->orderBy('TimeSlotStart')
        ->all();
//        \yii\helpers\VarDumper::dump($dataset, 10, true);
        
        return !empty($dataset) ? $dataset : [ ['', 0, 0, 0, 0, 0] ];

    }

    public function getPerfmonDatasetRep($cntr,$days=2)
    {
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
        if ($counter == 'disk') {
          try {
            $cmd = \Yii::$app->db->createCommand('exec dbo.usp_getDiskRep :d;');               
            $cmd->bindValue(':d', $days);
            $dataset = $cmd->queryAll(); 
          }catch (Exception $e) {
            Log::trace("Error : ".$e);
            throw new Exception("Error : ".$e);
          }
        } 
                
        if ($counter == 'net') {
          try {
            $cmd = \Yii::$app->db->createCommand('exec dbo.usp_getNetRep :d;');               
            $cmd->bindValue(':d', $days);
            $dataset = $cmd->queryAll(); 
          }catch (Exception $e) {
            Log::trace("Error : ".$e);
            throw new Exception("Error : ".$e);
          }
        } 
                
        return !empty($dataset) ? $dataset : [ [0, 0, 0, 0, 0] ];

    }

    public function getNetPerfDatasetRep($cntr,$days=2)
    {
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
        if ($counter == 'disk') {
          try {
            $cmd = \Yii::$app->db->createCommand('exec dbo.usp_getNetRep :d;');               
            $cmd->bindValue(':d', $days);
            $dataset = $cmd->queryAll(); 
          }catch (Exception $e) {
            Log::trace("Error : ".$e);
            throw new Exception("Error : ".$e);
          }
        } 
                
        return !empty($dataset) ? $dataset : [ [0, 0, 0, 0, 0] ];

    }

    public function getDriveDataset($srvr,$srvrId,$dt)
    {   
//        $dt = date('Y-m-d H:i:s',time() - 60 * 60 * 24 * 7);    
        $pcid = (new \yii\db\Query())
        ->select('id')->from('ServerData WITH (READPAST)')->where('Server=:srvr', array('srvr' => $srvr))
        ->scalar();
        
        $dataset = (new \yii\db\Query())
        ->select('DriveLetter, PercentFree, CaptureDate')->from('DriveData')->where('ServerId=:srvrId AND CaptureDate>:dt',
        array('srvrId' => $srvrId, 'dt' => $dt ))
        ->orderBy('DriveLetter,CaptureDate')
        ->all();
//        \yii\helpers\VarDumper::dump($dataset, 10, true);
        
        return !empty($dataset) ? $dataset : [ ['', 0, ''] ];

    }

   public function getWaitDataset($srvr,$dt)
    {
        
        $pcid = (new \yii\db\Query())
        ->select('id')->from('ServerData WITH (NOLOCK)')->where('Server=:srvr', array('srvr' => $srvr))
        ->scalar();
        
        $dataset = (new \yii\db\Query())
        ->select('Waits.CaptureEnd, WaitTypes.WaitType, Waits.WaitCount, Waits.Percentage, SumWaitSecs')->from('Waits WITH (NOLOCK)')
        ->join('INNER JOIN','WaitTypes WITH (NOLOCK)',
				'WaitTypes.id = Waits.WaitTypeId')
        ->where('ServerId=:srvr AND CaptureEnd>:dt',
        array('srvr' => $pcid, 'dt' => $dt ))->limit(50)
        ->orderBy('Waits.CaptureEnd, WaitTypes.WaitType,')
        ->all();
//        \yii\helpers\VarDumper::dump($dataset, 10, true);
        
        
      $waittypes = ArrayHelper::getColumn($dataset,'WaitType');
//      \yii\helpers\VarDumper::dump($waittypes, 10, true);
      
      $unique = array();
      foreach ($waittypes as $key => $value) {
                if (!in_array($value, $unique)) {
                    $unique[] = $value;
                }
                else {
                  $waittypes[$key] = "ttt";
                }
          }
      unset($value);  
      unset($unique);
//      \yii\helpers\VarDumper::dump($waittypes, 10, true);
      $waittypes = array_filter($waittypes, function($e)  {
          return ($e !== "ttt");
      });     
      sort($waittypes);
//      \yii\helpers\VarDumper::dump($waittypes, 10, true);

        return !empty($dataset) ? $dataset : [ [0, '', 0] ];

    }

    public static function getStatusimage ($status,$id,$ziel,$paused=0) {
//        \yii\helpers\VarDumper::dump($status, 10, true);
        if ($paused == 1)
          $status = "unknown";
        switch ($status) {
          case 'unknown':
              return Html::a(Html::img('@web/images/question-frame_open_commons.png', ['alt' => 'unknown', 'data-toggle'=>'tooltip','data-placement'=>'left','title' => 'unknown','style'=>'cursor:default;']), [$ziel, 'id' => $id]);
          case 'grey':
              return Html::a(Html::img('@web/images/alarm_unknown.png', ['alt' => 'neutral', 'data-toggle'=>'tooltip','data-placement'=>'left','title' => 'neutral']), [$ziel, 'id' => $id]);
          case 'green':
              return Html::a(Html::img('@web/images/check_16.png', ['alt' => 'green', 'data-toggle'=>'tooltip','data-placement'=>'left','title' => 'ok']), [$ziel, 'id' => $id]);
          case 'yellow':
              return Html::a(Html::img('@web/images/warning_16.png', ['alt' => 'yellow', 'data-toggle'=>'tooltip','data-placement'=>'left','title' => 'warning']), [$ziel, 'id' => $id]);
          case 'red':
              return Html::a(Html::img('@web/images/delete_angled_16.png', ['alt' => 'red', 'data-toggle'=>'tooltip','data-placement'=>'left','title' => 'alert']), [$ziel, 'id' => $id]);
        }
        return Html::a(Html::img('@web/images/delete_angled_16.png', ['alt' => 'red', 'data-toggle'=>'tooltip','data-placement'=>'left','title' => 'alert']), [$ziel, 'id' => $id]);
   }
   
    public static function getWaitimage ($status,$id,$ziel,$paused=0) {
//        \yii\helpers\VarDumper::dump($status, 10, true);
        if ($paused == 1)
          $status = "unknown";
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
        
        $pcid = ServerViewController::getPerfCounterDefaultId($counter);
        
        $pcsid = ServerViewController::getPerfCounterPerServerId($srvr, $counter, $instance);
        
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
      $anzahl = (count($zeiten)>10) ? 10 : count($zeiten);
      $daten = [$values, $avgvals]; 
//      \yii\helpers\VarDumper::dump($daten, 10, true);

      $tooltips = $values + $zeiten;

      for ($i = 0; $i < count($zeiten); ++$i) {
        $tooltips[$i] = $tooltips[$i] . '<br>'. substr($zeiten[$i],0,16);     
      }    
//      \yii\helpers\VarDumper::dump('Counter: '.$counter, 10, true);
        
      if ($output) return RGraphLine::widget([
          'data' => !empty($daten) ? $daten : [ [0,0] ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'allowContext' => true,
//          'id' => 'rgline_'.$pcid,
          'htmlOptions' => [
              'height' => ($detail==0) ? '180px' : '600px',
              'width' => ($detail==0) ? '280px' : '800px',
          ],
          'options' => [
//              'height' => ($detail==0) ? '180px' : '600px',
//              'width' => ($detail==0) ? '280px' : '800px',
//              'id' => 'rgline_'.$pcid,
              'colors' => ['blue','green'],
//              'filled' => true,
//              'clearto' => ['white'],
/*              'labels' => !empty($dataset) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset,'CaptureDate')
                          ) : [ 'No Data' ],
*/             'labels' => !empty($dataset) ? array_map(function($val) {return substr($val,0,16);},
                                    array_column(array_chunk(ArrayHelper::getColumn($dataset,'CaptureDate'),count($zeiten)/$anzahl),0)
                          ) : [ 'No Data' ],
              'tooltips' => $tooltips,
//              'tooltips' => !empty($dataset) ? array_map('strval',ArrayHelper::getColumn($dataset,'value')) : [ 'No Data' ],
//              'tooltips' => ['Link:<a href=\''.Url::to(['/test']).'\'>aaa</a>'],
  //            'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
  //            'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 7,
//              'textFonts' => 'arial condensed',
//              'gutter' => ['left' => 50, 'bottom' => 80, 'top' => 50],
              'gutter' => ['left' => ($detail==0) ? 50 : 50, 'bottom' => ($detail==0) ? 62 : 100, 'top' => 50],
              'title' => !empty($title) ? $title : $counter,
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'circle',
//              'ymax' => 100,
              'backgroundColor' => $bg,
              'contextmenu' => [
                  ['24h', new JsExpression('function go() {window.location.assign("'.Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 1 ]).'");}') ],
                  ['7 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 7 ])."\");}") ],
                  ['32 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 32 ])."\");}") ],
                  ['1 year', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_agg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 366 ])."\");}") ],
                  ['All', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_agg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 9999 ])."\");}") ],
                  ['Setting', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['perf-counter-per-server/update','id' => $pcsid ])."\");}") ],
              ],
          ]
      ]) //."<li>". Html::a('Settings', ['perf-counter-per-server/update', 'id' => $pcsid], ['class' => 'profile-link'])."</div>"
      ;    
    }
  
    public static function getWaitBar($srvr,$dataset,$cntr,$id,$detail=0,$title='') {
        
        $output = true;
        $detail = 1;
               
        $stat = 'unknown'; 
        
        $title = 'Wait-Typen';
        $cntr = 'Waits';
               
/*        if (!empty($pcid)) $stat = (new \yii\db\Query())->select('status')->from('PerfMonData')
        ->where('Server=:srvr AND Counter_id=:pcid AND instance=:inst', array('srvr' => $srvr, 'pcid' => $pcid, 'inst' => $instance ))
        ->orderBy('CaptureDate desc')->limit(1)->scalar();
*/
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
      $waittypes = ArrayHelper::getColumn($dataset,'WaitType');
      $unique = array();
      foreach ($waittypes as $key => $value) {
                if (!in_array($value, $unique)) {
                    $unique[] = $value;
                }
                else {
                  $waittypes[$key] = "ttt";
                }
          }
      unset($value);  
      unset($unique);
//      \yii\helpers\VarDumper::dump($waittypes, 10, true);
      $waittypes = array_filter($waittypes, function($e)  {
          return ($e !== "ttt");
      });     
      sort($waittypes);
//      \yii\helpers\VarDumper::dump($waittypes, 10, true);
      $zeiten = ArrayHelper::getColumn($dataset,'CaptureEnd');
      $unique = array();
      foreach ($zeiten as $key => $value) {
                if (!in_array($value, $unique)) {
                    $unique[] = $value;
                }
                else {
                  $zeiten[$key] = "ttt";
                }
          }
      unset($value);  
      unset($unique);
      $zeiten = array_filter($zeiten, function($e)  {
          return ($e !== "ttt");
      });     
      sort($zeiten);
//      \yii\helpers\VarDumper::dump($zeiten, 10, true);
      $anzahl = (count($zeiten)>10) ? 10 : count($zeiten);
      $ymaxy = 0;
      for ($i = 0; $i < count($zeiten); $i++) {
        $ymax = 0.0;
        for ($j = 0; $j < count($waittypes); $j++) {
          for ($k = 0; $k < count($dataset); $k++) {  
            if ($dataset[$k]['CaptureEnd'] == $zeiten[$i]) {
              if (!isset($zeile)) 
                $zeile = array(); 
              if ($dataset[$k]['WaitType'] == $waittypes[$j]) {
                $zeile[$j] = intval(($dataset[$k]['SumWaitSecs']/100)*$dataset[$k]['Percentage']);
//                $ymax = intval($dataset[$k]['SumWaitSecs']/100);
                $ymax += intval(($dataset[$k]['SumWaitSecs']/100)*$dataset[$k]['Percentage']);
              }  
              else 
                if (!isset($zeile[$j])) 
                  $zeile[$j] = 0;
            }
          }          
        }
        $daten[] = $zeile;
        unset($zeile);
        if ($ymax > $ymaxy) $ymaxy = $ymax;       
      }  
      $ymaxy = intval($ymaxy * 1.2);  
//      $avgvals = ArrayHelper::getColumn($dataset,'Percentage');
//      $daten = [$values, $avgvals]; 
      $tooltips = array();

      for ($i = 0; $i < count($zeiten); ++$i) {
        $tooltips[$i] = $waittypes;     
      }    

//      \Yii::warning(\yii\helpers\VarDumper::dumpAsString($daten),'application');
        
      if ($output) return RGraphBar::widget([
          'data' => !empty($daten) ? $daten : [ [0,0, 0] ],
          'allowDynamic' => true,
          'allowTooltips' => true,
//          'allowContext' => true,
          'allowKeys' => true,
          'allowResizing' => true,
//          'allowEffects' => true,
//          'allowAnnotate' => true,
          'id' => 'rgbar_Waits',
          'htmlOptions' => [
              'height' => ($detail==0) ? '180px' : '700px',
              'width' => ($detail==0) ? '280px' : '1200px',
          ],
          'options' => [
              'grouping' => 'stacked',
              'resizable' => true,
//              'linewidth' => 2,
//              'textAccessible' => true,
//              'strokestyle' => 'white',
              'hmargin' => 20,
              'hmarginGrouped' => 2,
//              'clearto' => 'white',              
//              'height' => ($detail==0) ? '180px' : '700px',
//              'width' => ($detail==0) ? '280px' : '1000px',
//              'id' => 'rgbar1_'.$id,
//              'colors' => ['blue','green'],
//              'filled' => true,
              'textAngle' => 45,
              'textSize' => 7,
              'textFonts' => 'arial condensed',
              'labelsAbove' => true,
              'labelsAboveDecimals' => 2,
              'labelsAboveSize' => 8,
              'labels' => !empty($zeiten) ? array_map(function($val) {return substr($val,0,16);},
                                    array_column(array_chunk($zeiten,count($zeiten)/$anzahl),0)
                          ) : [ 'No Data' ],
              'tooltips' => $tooltips,
              'key' => $waittypes,
              'keyInteractive' => true,
              'gutter' => ['left' => ($detail==0) ? 50 : 80, 'bottom' => ($detail==0) ? 80 : 100, 'top' => 50],
              'title' => !empty($title) ? $title : $counter,
              'titleSize' => 12,
              'titleBold' => false,
              'ymax' => $ymaxy,
              'backgroundColor' => $bg,
              'contextmenu' => [
                  ['24h', new JsExpression('function go() {window.location.assign("'.Url::toRoute(['detail_waits','cntr' => json_encode($cntr), 'id' => $id, 'days' => 1 ]).'");}') ],
                  ['7 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_waits','cntr' => json_encode($cntr), 'id' => $id, 'days' => 7 ])."\");}") ],
                  ['32 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_waits','cntr' => json_encode($cntr), 'id' => $id, 'days' => 32 ])."\");}") ],
/*                  ['1 year', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_agg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 366 ])."\");}") ],
                  ['All', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_agg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 9999 ])."\");}") ],
                  ['Setting', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['perf-counter-per-server/update','id' => $id ])."\");}") ],
*/              ],
          ],
      ]);    
    }
  
     public static function getServersMenu($target,$id) {
              
        $dataset1 = (new \yii\db\Query())
        ->select('Server as label, id as url')->from('ServerData')->where('paused <> 1')->orderBy('id')
        ->all(); 
        
        $items = array_map(function($srv) use ($target,$id) {
                            $srv['url'] = Url::home().$target.$srv['url'];
                            return $srv;} ,$dataset1);
//        \yii\helpers\VarDumper::dump($items, 10, true);

        return $items;
    }
    
    public function getNetPerfDataset($srvr,$cntr,$dt,$adapter='_Total')
    {
/*        $instance='_Total';
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
        $pcid = $this->getPerfCounterDefaultId($counter)
*/      
        $machine = (new \yii\db\Query())
        ->select('Value')->from('ServerConfig')->where('server=:sr AND Property=:prop', 
            array('sr' => $srvr, 'prop' => 'MachineName'))
        ->orderBy('CaptureDate desc')  
        ->limit(1)  
        ->scalar();
  
        if ($cntr == 'BytesTotalPersec') $fields = 'CaptureDate, BytesTotalPersec/(1024) AS Value, AvgBytesTotalPersec/(1024) AS AvgValue, CurrentBandwidth/(1024) AS CurrentBandwidth';
        if ($cntr == 'BytesReceivedPersec') $fields = 'CaptureDate, BytesReceivedPersec/(1024) AS Value, AvgBytesReceivedPersec/(1024) AS AvgValue, CurrentBandwidth/(1024) AS CurrentBandwidth';
        if ($cntr == 'BytesSentPersec') $fields = 'CaptureDate, BytesSentPersec/(1024) AS Value, AvgBytesSentPersec/(1024) AS AvgValue, CurrentBandwidth/(1024) AS CurrentBandwidth';        
        $dataset = (new \yii\db\Query())
        ->select($fields)->from('NetMonData')->where('Server=:srvr AND CaptureDate>:dt AND wmiNetAdapterName = :adapter',
        array('srvr' => $machine, 'dt' => $dt, 'adapter' => $adapter ))
        ->orderBy('CaptureDate')
        ->all();
//        \yii\helpers\VarDumper::dump($dataset, 10, true);
        
        return !empty($dataset) ? $dataset : [ [0, 0] ];

    }

    public static function getNetLine($srvr,$dataset,$cntr,$id,$detail=0,$title='') {
        
        $output = true;

        $instance='_Total';
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
/*        $pcid = ServerViewController::getPerfCounterDefaultId($counter)
        
        $pcsid = ServerViewController::getPerfCounterPerServerId($srvr, $counter, $instance);
*/        
        $stat = 'unknown';        
        $stat = (new \yii\db\Query())
                ->select('status')->from('PerfCounterPerServer')->where('Server=:srvr AND counter_name=:cntr AND instance = :inst', 
          ['srvr' => $srvr, 'cntr' => "Network Utilization", 'inst' => $instance])
        ->scalar();

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
//      \yii\helpers\VarDumper::dump($stat, 10, true);

      if (empty($dataset)) return '';
      $values = ArrayHelper::getColumn($dataset,'Value');
      $avgvals = ArrayHelper::getColumn($dataset,'AvgValue');
      $bandWidth = ArrayHelper::getColumn($dataset,'CurrentBandwidth');
      $zeiten = ArrayHelper::getColumn($dataset,'CaptureDate');
      $anzahl = (count($zeiten)>10) ? 10 : count($zeiten);
      $daten = [$values, $avgvals];  //   , $bandWidth
      $tooltips = $values + $zeiten;

      for ($i = 0; $i < count($zeiten); ++$i) {
        $tooltips[$i] = $tooltips[$i] . '<br>'. substr($zeiten[$i],0,16);     
      }    
//      \yii\helpers\VarDumper::dump('Counter: '.$counter, 10, true);
        
      if ($output) return RGraphLine::widget([
          'data' => !empty($daten) ? $daten : [ [0,0] ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'allowContext' => true,
//          'id' => 'rgline_'.$pcid,
          'htmlOptions' => [
              'height' => ($detail==0) ? '180px' : '600px',
              'width' => ($detail==0) ? '280px' : '800px',
          ],
          'options' => [
//              'height' => ($detail==0) ? '180px' : '600px',
//              'width' => ($detail==0) ? '280px' : '800px',
//              'id' => 'rgline_'.$pcid,
              'colors' => ['blue','green'], //    ,'orange'
//              'filled' => true,
              'clearto' => ['white'],
             'labels' => !empty($dataset) ? array_map(function($val) use ($detail){return substr($val,0,16);},
                                    array_column(array_chunk(ArrayHelper::getColumn($dataset,'CaptureDate'),count($zeiten)/$anzahl),0)
                          ) : [ 'No Data' ],
              'tooltips' => $tooltips,
              'textAngle' => 45,
              'textSize' => 7,
              'textFonts' => 'arial condensed',
              'gutter' => ['left' => ($detail==0) ? 60 : 60, 'bottom' => ($detail==0) ? 62 : 62, 'top' => 50],
              'title' => !empty($title) ? $title : 'Net k'.$cntr,
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'none', //'circle',
//              'ymax' => 100,
              'backgroundColor' => $bg,
              'contextmenu' => [
                  ['24h', new JsExpression('function go() {window.location.assign("'.Url::toRoute(['detail_net','cntr' => json_encode($cntr), 'id' => $id, 'days' => 1 ]).'");}') ],
                  ['7 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_net','cntr' => json_encode($cntr), 'id' => $id, 'days' => 7 ])."\");}") ],
                  ['32 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_net','cntr' => json_encode($cntr), 'id' => $id, 'days' => 32 ])."\");}") ],
                  ['1 year', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_net','cntr' => json_encode($cntr), 'id' => $id, 'days' => 366 ])."\");}") ],
                  ['All', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_net','cntr' => json_encode($cntr), 'id' => $id, 'days' => 9999 ])."\");}") ],
//                  ['Setting', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['perf-counter-per-server/update','id' => $pcsid ])."\");}") ],
              ],
          ]
      ]) //."<li>". Html::a('Settings', ['perf-counter-per-server/update', 'id' => $pcsid], ['class' => 'profile-link'])."</div>"
      ;    
  }
    
    public static function getPaintLineAgg($srvr,$dataset,$cntr,$id,$detail=0,$title='') {
        
        $output = true;
        
        $instance='_Total';
        if (is_array($cntr)) {$counter = $cntr[0]; $instance = $cntr[1];}
        else $counter = $cntr;
        
        $pcid = ServerViewController::getPerfCounterDefaultId($counter);
        
        $pcsid = ServerViewController::getPerfCounterPerServerId($srvr, $counter, $instance);
        
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
      $minvals = ArrayHelper::getColumn($dataset,'MinVal');
      $avgvals = ArrayHelper::getColumn($dataset,'AvgVal');
      $avgvals = ArrayHelper::getColumn($dataset,'AvgVal');      
      $maxvals = ArrayHelper::getColumn($dataset,'MaxVal');      
      $medvals = ArrayHelper::getColumn($dataset,'Median');      
      $stdvals = ArrayHelper::getColumn($dataset,'StdDev');      
      $zeiten = ArrayHelper::getColumn($dataset,'TimeSlotStart');
      $anzahl = (count($zeiten)>10) ? 10 : count($zeiten);
      $daten = [$minvals, $avgvals, $maxvals, $medvals, $stdvals]; 
      $tooltips = $medvals + $zeiten;

      for ($i = 0; $i < count($zeiten); ++$i) {
        $tooltips[$i] = $tooltips[$i] . '<br>'. substr($zeiten[$i],0,16);     
      }    
//      \yii\helpers\VarDumper::dump('Counter: '.$counter, 10, true);
        
      if ($output) return RGraphLine::widget([
          'data' => !empty($daten) ? $daten : [ [0,0] ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'allowContext' => true,
          'allowKeys' => true,
//          'id' => 'rgline_'.$pcid,
          'htmlOptions' => [
              'height' => ($detail==0) ? '180px' : '600px',
              'width' => ($detail==0) ? '280px' : '900px',
          ],
          'options' => [
              'height' => ($detail==0) ? '180px' : '600px',
              'width' => ($detail==0) ? '280px' : '800px',
//              'id' => 'rgline_'.$pcid,
              'colors' => ['blue','green', 'orange', 'red', 'yellow'],
//              'filled' => true,
              'clearto' => ['white'],
/*              'labels' => !empty($dataset) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset,'CaptureDate')
                          ) : [ 'No Data' ],
*/             'labels' => !empty($dataset) ? array_map(function($val) use ($detail){return substr($val,0,16);},
                                    array_column(array_chunk(ArrayHelper::getColumn($dataset,'CaptureDate'),count($zeiten)/$anzahl),0)
                          ) : [ 'No Data' ],
              'tooltips' => $tooltips,
//              'tooltips' => !empty($dataset) ? array_map('strval',ArrayHelper::getColumn($dataset,'value')) : [ 'No Data' ],
//              'tooltips' => ['Link:<a href=\''.Url::to(['/test']).'\'>aaa</a>'],
  //            'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
  //            'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 8,
//              'gutter' => ['left' => 50, 'bottom' => 80, 'top' => 50],
              'gutter' => ['left' => ($detail==0) ? 80 : 80, 'bottom' => ($detail==0) ? 50 : 80, 'top' => 50, 'right' => 50],
              'title' => !empty($title) ? $title : $counter,
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'none',
//              'ymax' => 100,
              'backgroundColor' => $bg,
              'contextmenu' => [
                  ['24h', new JsExpression('function go() {window.location.assign("'.Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 1 ]).'");}') ],
                  ['7 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 7 ])."\");}") ],
                  ['32 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 32 ])."\");}") ],
                  ['1 year', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detailAgg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 366 ])."\");}") ],
                  ['All', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detailAgg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 9999 ])."\");}") ],
                  ['Setting', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['perf-counter-per-server/update','id' => $pcsid ])."\");}") ],
              ],
          ]
      ]) //."<li>". Html::a('Settings', ['perf-counter-per-server/update', 'id' => $pcsid], ['class' => 'profile-link'])."</div>"
      ;    
    }

    public static function getPaintLineRep($dataset, $title='') {
        
        $output = true;
        $stat = 'unknown';        
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
      $zeiten = ArrayHelper::getColumn($dataset,'TimeSlotStart');
      $anzahl = (count($zeiten)>10) ? 10 : count($zeiten);
      $labels = array();
      for ($i=1;$i<$anzahl;$i++) {
        $labels[] = $zeiten[($i*count($zeiten))/$anzahl];
      }
      $cols = array_keys($dataset[1]);
//      \yii\helpers\VarDumper::dump($cols, 10, true);
      foreach ($cols as $col) {
          if ($col != "TimeSlotStart") {
            $rows = ArrayHelper::getColumn($dataset, $col); 
            $daten[] = $rows;
            $keys[] = $col;
          }  
      }
     $tooltips = $zeiten;

//       \yii\helpers\VarDumper::dump($tooltips, 10, true);
        
      if ($output) return RGraphLine::widget([
          'data' => !empty($daten) ? $daten : [ [0,0] ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'allowContext' => true,
          'allowKeys' => true,
//          'id' => 'rgline_'.$pcid,
          'htmlOptions' => [
              'height' => '700px',
              'width' => '1024px',
          ],
          'options' => [
              'height' => '800px',
              'width' => '1280px',
//              'id' => 'rgline_'.$pcid,
//              'colors' => ['blue','green', 'orange', 'red', 'yellow'],
//              'filled' => true,
              'clearto' => ['white'],
/*              'labels' => !empty($dataset) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset,'CaptureDate')
                          ) : [ 'No Data' ],
*/             'labels' => !empty($dataset) ? array_map(function($val){return substr($val,0,16);},
                                    array_column(array_chunk(ArrayHelper::getColumn($dataset,'TimeSlotStart'),count($zeiten)/$anzahl),0)
                          ) : [ 'No Data' ],
              'crosshairs' => false,
              'tooltips' => $tooltips,
//              'tooltips' => !empty($dataset) ? array_map('strval',ArrayHelper::getColumn($dataset,'value')) : [ 'No Data' ],
//              'tooltips' => ['Link:<a href=\''.Url::to(['/test']).'\'>aaa</a>'],
  //            'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
  //            'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 8,
//              'gutter' => ['left' => 50, 'bottom' => 80, 'top' => 50],
              'gutter' => ['left' =>  70, 'bottom' => 80, 'top' => 50, 'right' => 50],
              'title' => !empty($title) ? $title : '',
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'none',
              'key' => $keys,
              'keyPosition' => 'graph',
              'keyInteractive' => true,
//              'ymax' => 100,
              'backgroundColor' => $bg,
/*              'contextmenu' => [
                  ['24h', new JsExpression('function go() {window.location.assign("'.Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 1 ]).'");}') ],
                  ['7 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 7 ])."\");}") ],
                  ['32 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail','cntr' => json_encode($cntr), 'id' => $id, 'days' => 32 ])."\");}") ],
                  ['1 year', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detailAgg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 366 ])."\");}") ],
                  ['All', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detailAgg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 9999 ])."\");}") ],
                 ['Setting', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['perf-counter-per-server/update','id' => $pcsid ])."\");}") ],
              ],
*/           ]
      ]) //."<li>". Html::a('Settings', ['perf-counter-per-server/update', 'id' => $pcsid], ['class' => 'profile-link'])."</div>"
      ;    
    }
  
    public static function getPaintLineDrives($dataset,$id=0) {
        
        $output = true;
        $title = 'Drivespace Percent Free';
        $cntr = 'drivespace';
        $stat = 'unknown';        
/*        if (!empty($pcid)) $stat = (new \yii\db\Query())->select('status')->from('PerfMonData')
        ->where('Server=:srvr AND Counter_id=:pcid AND instance=:inst', array('srvr' => $srvr, 'pcid' => $pcid, 'inst' => $instance ))
        ->orderBy('CaptureDate desc')->limit(1)->scalar();
*/
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
      if (is_Array($dataset)) 
        $zeiten = ArrayHelper::getColumn($dataset,'CaptureDate');
      $unique = array();
      foreach ($zeiten as $row) 
        if (!in_array($row, $unique)) {
                $unique[] = (string)$row;
        }
      $zeiten = $unique;
      unset($unique);
//      \yii\helpers\VarDumper::dump($zeiten, 10, true);
      
      $anzahl = (count($zeiten)>10) ? 10 : count($zeiten);
//      $labels = array();
//      for ($i=1;$i<$anzahl;$i++) {
//        $labels[] = $zeiten[($i*count($zeiten))/$anzahl];
//      }
      $labels = array_column(array_chunk($zeiten,count($zeiten)/$anzahl),0);
      $cols = array_keys($dataset[1]);
//      \yii\helpers\VarDumper::dump($cols, 10, true);

      $rows = ArrayHelper::getColumn($dataset, "DriveLetter");
      $unique = array();
      foreach ($rows as $row) 
        if (!in_array($row, $unique)) {
                $unique[] = $row;
        }
      $keys = $unique;
      unset($unique);
//      \yii\helpers\VarDumper::dump($keys, 10, true);      

      $rows = ArrayHelper::getColumn($dataset, "PercentFree");
      $j = 0;
      foreach ($keys as $key) {
        $dat[] = array();
        for ($i = 0; $i < count($dataset); $i++) {
          if ($dataset[$i]['DriveLetter'] == $key) $dat[$j][] = $dataset[$i]['PercentFree'] ;     
        }
        $j++;
      }      
//      \yii\helpers\VarDumper::dump('$dat', 10, true);
//      \yii\helpers\VarDumper::dump($dat, 10, true);
     $tooltips = $zeiten;

//       \yii\helpers\VarDumper::dump($tooltips, 10, true);
//      \yii\helpers\VarDumper::dump($daten, 10, true);
        
      if ($output) return RGraphLine::widget([
          'data' => !empty($dat) ? $dat : [ [0,0,0,0,0] ],
          'allowDynamic' => true,
          'allowTooltips' => true,
          'allowContext' => true,
          'allowKeys' => true,
//          'id' => 'rgline_'.$pcid,
          'htmlOptions' => [
              'height' => '400px',
              'width' => '640px',
          ],
          'options' => [
              'height' => '400px',
              'width' => '640px',
//              'id' => 'rgline_'.$pcid,
//+              'colors' => ['blue','green', 'orange', 'red', 'yellow'],
//              'filled' => true,
              'clearto' => ['white'],
/*              'labels' => !empty($dataset) ? array_map(function($val){return substr($val,11,5);},
                                    ArrayHelper::getColumn($dataset,'CaptureDate')
                          ) : [ 'No Data' ],
*/             'labels' => $labels,
              'crosshairs' => false,
              'tooltips' => $tooltips,
//              'tooltips' => !empty($dataset) ? array_map('strval',ArrayHelper::getColumn($dataset,'value')) : [ 'No Data' ],
//              'tooltips' => ['Link:<a href=\''.Url::to(['/test']).'\'>aaa</a>'],
  //            'eventsClick' => 'function (e) {window.open(\'http://news.bbc.co.uk\', \'_blank\');} ',
  //            'eventsMousemove' => 'function (e) {e.target.style.cursor = \'pointer\';}',
              'textAngle' => 45,
              'textSize' => 8,
//              'gutter' => ['left' => 50, 'bottom' => 80, 'top' => 50],
              'gutter' => ['left' =>  70, 'bottom' => 80, 'top' => 50, 'right' => 50],
              'title' => !empty($title) ? $title : '',
              'titleSize' => 12,
              'titleBold' => false,
              'tickmarks' => 'circle',
              'key' => $keys,
              'keyPosition' => 'graph',
              'keyInteractive' => true,
              'ymax' => 100,
              'backgroundColor' => $bg,
              'contextmenu' => [
 //                 ['24h', new JsExpression('function go() {window.location.assign("'.Url::toRoute(['detail_disk','cntr' => json_encode($cntr), 'id' => $id, 'days' => 1 ]).'");}') ],
                  ['7 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_disk','cntr' => json_encode($cntr), 'id' => $id, 'days' => 7 ])."\");}") ],
                  ['32 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_disk','cntr' => json_encode($cntr), 'id' => $id, 'days' => 32 ])."\");}") ],
                  ['95 days',new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detail_disk','cntr' => json_encode($cntr), 'id' => $id, 'days' => 95 ])."\");}") ],
 //                 ['1 year', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detailAgg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 366 ])."\");}") ],
 //                 ['All', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['detailAgg','cntr' => json_encode($cntr), 'id' => $id, 'days' => 9999 ])."\");}") ],
 //                ['Setting', new JsExpression("function go() {window.location.assign(\"".Url::toRoute(['perf-counter-per-server/update','id' => $pcsid ])."\");}") ],
              ],
           ]
      ]) //."<li>". Html::a('Settings', ['perf-counter-per-server/update', 'id' => $pcsid], ['class' => 'profile-link'])."</div>"
      ;    
    }
  
}
