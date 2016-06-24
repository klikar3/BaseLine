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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
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
        $this->findModel($id)->delete();

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
