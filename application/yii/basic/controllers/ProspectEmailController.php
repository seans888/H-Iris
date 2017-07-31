<?php

namespace app\controllers;

use Yii;
use app\models\ProspectEmail;
use app\models\ProspectEmailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProspectEmailController implements the CRUD actions for ProspectEmail model.
 */
class ProspectEmailController extends Controller
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
     * Lists all ProspectEmail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProspectEmailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProspectEmail model.
     * @param integer $prospect_id
     * @param integer $email_id
     * @return mixed
     */
    public function actionView($prospect_id, $email_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($prospect_id, $email_id),
        ]);
    }

    /**
     * Creates a new ProspectEmail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProspectEmail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'prospect_id' => $model->prospect_id, 'email_id' => $model->email_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProspectEmail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $prospect_id
     * @param integer $email_id
     * @return mixed
     */
    public function actionUpdate($prospect_id, $email_id)
    {
        $model = $this->findModel($prospect_id, $email_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'prospect_id' => $model->prospect_id, 'email_id' => $model->email_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProspectEmail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $prospect_id
     * @param integer $email_id
     * @return mixed
     */
    public function actionDelete($prospect_id, $email_id)
    {
        $this->findModel($prospect_id, $email_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProspectEmail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $prospect_id
     * @param integer $email_id
     * @return ProspectEmail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($prospect_id, $email_id)
    {
        if (($model = ProspectEmail::findOne(['prospect_id' => $prospect_id, 'email_id' => $email_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
