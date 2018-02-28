<?php

namespace app\controllers;

use app\models\Vuelos;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * VuelosController implements the CRUD actions for Vuelos model.
 */
class VuelosController extends Controller
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
     * Lists all Vuelos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $v = Vuelos::find()
            ->joinWith('reservas')
            ->select('vuelos.*, (vuelos.plazas - count(vuelo_id)) as libres')
            ->groupBy('vuelos.id, vuelo_id')
            ->where(['>', 'salida', date('Y-m-d H:i:s')]);

        $dataProvider = new ActiveDataProvider([
            'query' => $v,
            // 'query' => Vuelos::find()->where(['>', 'salida', date('Y-m-d H:i:s')]),
            // 'query' => Vuelos::find()->where(new Expression('salida > current_timestamp')),
        ]);

        $dataProvider->sort->attributes['libres'] = [
            'asc' => ['libres' => SORT_ASC],
            'desc' => ['libres' => SORT_DESC],
        ];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPlazasLibres($vuelo_id)
    {
        $vuelo = Vuelos::findOne(['id' => $vuelo_id]);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($vuelo === null) {
            return [-1];
        }

        return $vuelo->asientoslibres;
    }

    /**
     * Displays a single Vuelos model.
     * @param int $id
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
     * Creates a new Vuelos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vuelos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Vuelos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
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
     * Deletes an existing Vuelos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Vuelos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Vuelos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vuelos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
