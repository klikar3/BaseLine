<?php

namespace app\controllers;

use Yii;
use app\models\ServerData;
use app\models\ServerDataSearch;
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
        } catch (Exception $e) {
            Log::trace("Error : ".$e);
            throw new Exception("Error : ".$e);
          }
        parent::init();
    }

    public function behaviors()
    {
        return [
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
        $searchModel = new ServerDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
    public function actionCreate()
    {
        $model = new ServerData();
        
        //$data = Yii::$app->request->post();
        //Yii::error($data['ServerData']['usr'],'application');
        //\yii\helpers\VarDumper::dump($data, 10, true)

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            try {
                \Yii::$app->db->createCommand("USE BASELINEDATA; EXEC [dbo].[usp_getConfigData] '".$model->Server."'")
                ->execute();
            } catch (\yii\db\Exception $e) {
                $model->addError('Server', Yii::t('app', 'Konnte Serverkonfiguration nicht auslesen.').$e->getmessage());
                return $this->render('create', [
                'model' => $model, 
            ]);
            }        
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
//            $model->setUsr('iii') ;//$data['ServerData']['usr'];
//            $model->setPwd('ooo'); //$data['ServerData']['pwd'];
//            Yii::error($model['usr'],'application');
            return $this->render('create', [
                'model' => $model, 
            ]);
        }
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
                Yii::info(\yii\helpers\VarDumper::dump($model, 10, true),'application'); 
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

    /**
     * Deletes an existing ServerData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->db->transaction(function(){
        
            foreach($this->ServerConfig as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen ServerConfig. Errors: '. 
                                        join(', ', $ServerData->getFirstErrors()));
                }
            }
            
            foreach($this->DbData as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen DbData. Errors: '. 
                                        join(', ', $ServerData->getFirstErrors()));
                }
            }
            
            foreach($this->PerfmonDataAgg1H as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen PerfmonDataAgg1H. Errors: '. 
                                        join(', ', $ServerData->getFirstErrors()));
                }
            }
            
            foreach($this->PerfMonData as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen PerfMonData. Errors: '. 
                                        join(', ', $ServerData->getFirstErrors()));
                }
            }
            
            foreach($this->IoCounters as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen IoCounters. Errors: '. 
                                        join(', ', $ServerData->getFirstErrors()));
                }
            }
            
            foreach($this->NetMonData as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen NetMonData. Errors: '. 
                                        join(', ', $ServerData->getFirstErrors()));
                }
            }
            
            foreach($this->NetmonDataAgg1H as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen NetmonDataAgg1H. Errors: '. 
                                        join(', ', $ServerData->getFirstErrors()));
                }
            }
            
            foreach($this->PerfCounterDefaultServer as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen PerfCounterDefaultServer. Errors: '. 
                                        join(', ', $ServerData->getFirstErrors()));
                }
            }
            
            foreach($this->ConfigData as $c){
                if( !$c->delete() ){
                    throw new Exception('Fehler beim löschen der zugehörigen ConfigData. Errors: '.
                                        join(', ', $ServerData->getFirstErrors()));
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
