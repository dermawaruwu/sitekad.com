<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Kegiatan;
use frontend\models\KegiatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Periode;
use frontend\models\Seksi;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\data\ArrayDataProvider;


/**
 * KegiatanController implements the CRUD actions for Kegiatan model.
 */
class KegiatanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'data'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Kegiatan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KegiatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id'=>SORT_DESC]];
        $dataProvider->query
            //->where(["kegiatan.created_by" => \Yii::$app->user->id])
            ->andFilterWhere(['kegiatan.isDeleted' => 0])
            ->orderBy('updated_at DESC');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kegiatan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kegiatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kegiatan();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->isDeleted = FALSE;
            $model->seksi = \Yii::$app->user->id;
            $model->id = \thamtech\uuid\helpers\UuidHelper::uuid();
            if($model->save()){
                return $this->redirect(['index']);
            }
            
        } else {
            $periodeDropdown = $this->periodeDropdown();
            $seksiDropdown = $this->seksiDropdown();
            return $this->render('create', [
                "periodeDropdown" => $periodeDropdown,
                "seksiDropdown" => $seksiDropdown,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Kegiatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            $periodeDropdown = $this->periodeDropdown();
            $seksiDropdown = $this->seksiDropdown();
            return $this->render('update', [
                "periodeDropdown" => $periodeDropdown,
                "seksiDropdown" => $seksiDropdown,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Kegiatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found 
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kegiatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kegiatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kegiatan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function periodeDropdown(){
        $periode = ArrayHelper::map(Periode::find()->all(), "id", "periode");
        return $periode;
    }

    public function seksiDropdown(){
        $seksi = ArrayHelper::map(Seksi::find()->all(), "id", "nama");
        return $seksi;
    }
    
}
