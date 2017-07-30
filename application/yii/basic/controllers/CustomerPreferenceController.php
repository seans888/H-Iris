<?php

namespace app\controllers;

use Yii;
use app\models\CustomerPreference;
use app\models\CustomerPreferenceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerPreferenceController implements the CRUD actions for CustomerPreference model.
 */
class CustomerPreferenceController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all CustomerPreference models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerPreferenceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerPreference model.
     * @param integer $customer_id
     * @param integer $preference_id
     * @return mixed
     */
    public function actionView($customer_id, $preference_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($customer_id, $preference_id),
        ]);
    }

    /**
     * Creates a new CustomerPreference model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CustomerPreference();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'customer_id' => $model->customer_id, 'preference_id' => $model->preference_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CustomerPreference model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $customer_id
     * @param integer $preference_id
     * @return mixed
     */
    public function actionUpdate($customer_id, $preference_id)
    {
        $model = $this->findModel($customer_id, $preference_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'customer_id' => $model->customer_id, 'preference_id' => $model->preference_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CustomerPreference model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $customer_id
     * @param integer $preference_id
     * @return mixed
     */
    public function actionDelete($customer_id, $preference_id)
    {
        $this->findModel($customer_id, $preference_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CustomerPreference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $customer_id
     * @param integer $preference_id
     * @return CustomerPreference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($customer_id, $preference_id)
    {
        if (($model = CustomerPreference::findOne(['customer_id' => $customer_id, 'preference_id' => $preference_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
