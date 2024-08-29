<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\ServerData;
use app\models\ServerDataSearch;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ServerDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('paused <> 1');
        $dataProvider->query->orderBy = ['typ' => SORT_ASC];
        $dataProvider->pagination = ['pageSize' => 25];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
//        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionWartung()
    {
        // Wartungsfenster
/*        $sql = "SELECT sj.*, 
	CASE
        WHEN sja.start_execution_date IS NULL THEN 'Not running'
        WHEN sja.start_execution_date IS NOT NULL AND sja.stop_execution_date IS NULL THEN 'Running'
        WHEN sja.start_execution_date IS NOT NULL AND sja.stop_execution_date IS NOT NULL THEN 'Not running'
    END AS 'RunStatus'
FROM msdb.dbo.sysjobs sj
JOIN msdb.dbo.sysjobactivity sja
ON sj.job_id = sja.job_id
WHERE session_id = ( SELECT MAX(session_id) FROM msdb.dbo.sysjobactivity) and sj.name like 'RST-Check-%'";

        try { 
          $dataProvider = new SqlDataProvider([
              'sql' => $sql, //ConfigData::find()->where(['Server' => $servername])->andWhere(['CaptureDate' => $datum]),
              'db' => Yii::$app->db,
                'pagination' => [
                  'pageSize' => 15,
              ],
          ]);
        } catch(\Exception $e) {
          \Yii::trace("Error : ".$e);
          $dataProvider = $this->emptyProvider();
        }

*/

        $searchModel = new ServerDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('paused <> 1');
        $dataProvider->query->orderBy = ['typ' => SORT_ASC];
        $dataProvider->pagination = ['pageSize' => 25];


        return $this->render('wartung', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
//        return $this->render('index');
    }

    public static function emptyProvider() {
      $data = [
          ['id' => 1, 'name' => 'Prüfungen',],
          ['id' => 2, 'name' => 'Programme',],
      ];
      
      $provider = new ArrayDataProvider([
          'allModels' => $data,
          'pagination' => false,
          'sort' => false,
      ]);

      return $provider;
    }
    
    
}
