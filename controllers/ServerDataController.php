<?php

namespace app\controllers;

use Yii;
use app\models\ServerData;
use app\models\ServerDataSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServerDataController implements the CRUD actions for ServerData model.
 */
class ServerDataController extends Controller
{
    public function init() {
        try {
           \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT 1 as a; ')->execute();               
        } catch (\Exception $e) {
            \Yii::trace("Error : ".$e);
            throw new \Exception("Error : ".$e);
          }
        parent::init();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update','index'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ServerData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = \Yii::$app->session;
        if ($session->has('refreshTime')) {
          $refreshTime = $session->get('refreshTime');
        } else {
          $refreshTime = 60;
          $session->set('refreshTime','60');          
        }

        
        $searchModel = new ServerDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'refreshTime' => $refreshTime,          
        ]);
    }

    /**
     * Displays a single ServerData model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ServerData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($mod = null, $pwdgen = false )
    {
        if ($pwdgen && (!empty($mod))) {
          $model = $mod;
          $model->pwd = trim(com_create_guid(), '{}');
          return $this->render('create', [
              'model' => $model, 
          ]);
        }
        
        $model = new ServerData();
        
        //$data = Yii::$app->request->post();
        //Yii::warning(\yii\helpers\VarDumper::dump($data, 10, true),'application');
        //\yii\helpers\VarDumper::dump($data, 10, true)

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->typ == 'sql') {
              try {
                  \Yii::$app->db->createCommand("USE BASELINEDATA; EXEC [dbo].[usp_getConfigData] '".$model->Server."'")
                  ->execute();
              } catch (\yii\db\Exception $e) {
                  $model->addError('Server', Yii::t('app', 'Konnte SQL-Konfiguration nicht auslesen - wurde der SQL-User schon angelegt und mit Berechtigungen versehen?').$e->getmessage());
                  return $this->render('create', [
                    'model' => $model, 
                  ]);
              }        
              try {
                  \Yii::$app->db->createCommand("USE BASELINEDATA; EXEC [dbo].[usp_getServerData] '".$model->Server."'")
                  ->execute();
              } catch (\yii\db\Exception $e) {
                  $model->addError('Server', Yii::t('app', 'Konnte Serverkonfiguration nicht auslesen - wurde der SQL-User schon angelegt und mit Berechtigungen versehen?').$e->getmessage());
                  return $this->render('create', [
                    'model' => $model, 
                  ]);
              }        
              try {
                  \Yii::$app->db->createCommand("USE BASELINEDATA; EXEC [dbo].[usp_getSecurity] '".$model->Server."'")
                  ->execute();
              } catch (\yii\db\Exception $e) {
                  $model->addError('Server', Yii::t('app', 'Konnte Sicherheit nicht auslesen - wurde der SQL-User schon angelegt und mit Berechtigungen versehen?').$e->getmessage());
                  return $this->render('create', [
                    'model' => $model, 
                  ]);
              }
            }          
            return $this->redirect(['view', 'id' => $model->id]);
        }
//            $model->setUsr('iii') ;//$data['ServerData']['usr'];
//            $model->setPwd('ooo'); //$data['ServerData']['pwd'];
//            Yii::error($model['usr'],'application');
        $model->usr = 'ignite';
        $model->pwd = trim(com_create_guid(), '{}');
//        Yii::warning($model->usr, 'application'); 
//        Yii::warning($model->pwd, 'application');

 
        return $this->render('create', [
            'model' => $model, 
        ]);
    }

    /**
     * Updates an existing ServerData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Yii::$app->request->post();
//        Yii::info(\yii\helpers\VarDumper::dump($data, 10, true),'application');
//        Yii::info(\yii\helpers\VarDumper::dump($data['ServerData']['usr'], 10, true),'application');
        if ($model->load($data) ) {
            if (!is_null(\Yii::$app->request->post('pwsubmit'))) {
              $model->pwd = trim(com_create_guid(), '{}');
              $model->setPwd(trim(com_create_guid(), '{}'));
              return $this->render('update', [
                  'model' => $model 
              ]);
            }
            if (!empty($data['ServerData']['usr'])) {
                $model->User_Encrypted = \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_encrypt_ServerData(:u, :srvr) ')
                          ->bindValues([':u' => $data['ServerData']['usr'], ':srvr' => $model->Server])->queryScalar();
                $model->usr = $data['ServerData']['usr'];
            }
            if (!empty($data['ServerData']['pwd'])) {
                $model->Password_Encrypted = \Yii::$app->db->createCommand('OPEN SYMMETRIC KEY [key_DataShare] DECRYPTION BY CERTIFICATE [cert_keyProtection]; SELECT dbo.uf_encrypt_ServerData(:u, :srvr) ')
                          ->bindValues([':u' => $data['ServerData']['pwd'], ':srvr' => $model->Server])->queryScalar();
                $model->pwd = $data['ServerData']['pwd'];
            }
            if  ($model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
            } else {
//                Yii::error('!!! no save','application');
//                Yii::info(\yii\helpers\VarDumper::dump($model, 10, true),'application'); 
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
//            Yii::error('no load','application');
            $model->getUsr();
            $model->getPwd();
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionNewpw($id, $modl = null)
    {
        $model = empty($modl) ? $this->findModel($id) : $modl;
        $data = Yii::$app->request->post();
//        Yii::info(\yii\helpers\VarDumper::dump($data, 10, true),'application');
//        Yii::info(\yii\helpers\VarDumper::dump($data['ServerData']['usr'], 10, true),'application');
        if ($model->load($data) ) {
              $model->pwd = trim(com_create_guid(), '{}');
              $model->setPwd(trim(com_create_guid(), '{}'));
              return $this->render('update', [
                  'model' => $model 
              ]);
        } else {
//            Yii::error('no load','application');
            $model->getUsr();
            $model->getPwd();
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Deletes an existing ServerData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->db->transaction(function() use ($id){
        
            $model = $this->findModel($id);
            
            foreach($model->ServerConfig as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen ServerConfig. Errors: '. 
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            foreach($model->DbData as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen DbData. Errors: '. 
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            foreach($model->PerfmonDataAgg1H as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen PerfmonDataAgg1H. Errors: '. 
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            foreach($model->PerfMonData as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen PerfMonData. Errors: '. 
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            foreach($model->IoCounters as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen IoCounters. Errors: '. 
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            foreach($model->NetMonData as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen NetMonData. Errors: '. 
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            foreach($model->NetmonDataAgg1H as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen NetmonDataAgg1H. Errors: '. 
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            foreach($model->PerfCounterDefaultServer as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen PerfCounterDefaultServer. Errors: '. 
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            foreach($model->ConfigData as $c){
                if( !$c->delete() ){
                    throw new \Exception('Fehler beim löschen der zugehörigen ConfigData. Errors: '.
                                        join(', ', $model->getFirstErrors()));
                }
            }
            
            $this->findModel($id)->delete();
        });

        return $this->redirect(['index']);
    }

    /**
     * Finds the ServerData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ServerData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ServerData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
