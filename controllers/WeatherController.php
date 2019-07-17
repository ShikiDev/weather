<?php

namespace app\controllers;

use app\components\WeatherParser;
use Faker\Provider\DateTime;
use Yii;
use app\models\Weather;
use app\models\WeatherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeatherController implements the CRUD actions for Weather model.
 */
class WeatherController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Weather models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WeatherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Weather model.
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
     * Creates a new Weather model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Weather();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Weather model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Weather model.
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
     * Finds the Weather model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Weather the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Weather::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionWeather()
    {
        $date = new \DateTime('now');
        if (!$model = Weather::getByDate($date->modify('+9 day')->format('Y-m-d'))) {
            $result = WeatherParser::collectData();
            ksort($result);
            foreach ($result as $day => $res) {
                if ($day < date('d')) {
                    $date_formatting = new \DateTime('now');
                    $month_n_year = $date_formatting->modify('+1 month')->format('Y-m');
                } else {
                    $date_formatting = new \DateTime('now');
                    $month_n_year = $date_formatting->format('Y-m');
                }
                $model = new Weather();
                $model->setAttribute('data', json_encode($res));
                $model->setAttribute('city', 'Moscow');
                $model->setAttribute('date', $month_n_year . '-' . $day);
                if (!$model->save(false)) continue;
            }
        }

        $date = new \DateTime();
        $today = $date->format('Y-m-d');
        $result = Weather::getWeekWeather($today);

        return $this->render('parsed_page', [
            'result' => $result
        ]);
    }
}
