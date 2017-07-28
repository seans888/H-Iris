<?php

namespace app\controllers;

use Yii;
use app\models\EmailCustomer;
use app\models\EmailCustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmailCustomerController implements the CRUD actions for EmailCustomer model.
 */
class EmailCustomerController extends Controller
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
     * Lists all EmailCustomer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmailCustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmailCustomer model.
     * @param integer $email_id
     * @param integer $customer_id
     * @return mixed
     */
    public function actionView($email_id, $customer_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($email_id, $customer_id),
        ]);
    }

    /**
     * Creates a new EmailCustomer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmailCustomer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'email_id' => $model->email_id, 'customer_id' => $model->customer_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EmailCustomer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $email_id
     * @param integer $customer_id
     * @return mixed
     */
    public function actionUpdate($email_id, $customer_id)
    {
        $model = $this->findModel($email_id, $customer_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'email_id' => $model->email_id, 'customer_id' => $model->customer_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EmailCustomer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $email_id
     * @param integer $customer_id
     * @return mixed
     */
    public function actionDelete($email_id, $customer_id)
    {
        $this->findModel($email_id, $customer_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmailCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $email_id
     * @param integer $customer_id
     * @return EmailCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($email_id, $customer_id)
    {
        if (($model = EmailCustomer::findOne(['email_id' => $email_id, 'customer_id' => $customer_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
