<?php

namespace app\controllers;

use Yii;
use app\models\ProspectPreference;
use app\models\ProspectPreferenceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProspectPreferenceController implements the CRUD actions for ProspectPreference model.
 */
class ProspectPreferenceController extends Controller
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
     * Lists all ProspectPreference models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProspectPreferenceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProspectPreference model.
     * @param integer $prospect_id
     * @param integer $preference_id
     * @return mixed
     */
    public function actionView($prospect_id, $preference_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($prospect_id, $preference_id),
        ]);
    }

    /**
     * Creates a new ProspectPreference model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProspectPreference();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'prospect_id' => $model->prospect_id, 'preference_id' => $model->preference_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProspectPreference model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $prospect_id
     * @param integer $preference_id
     * @return mixed
     */
    public function actionUpdate($prospect_id, $preference_id)
    {
        $model = $this->findModel($prospect_id, $preference_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'prospect_id' => $model->prospect_id, 'preference_id' => $model->preference_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProspectPreference model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $prospect_id
     * @param integer $preference_id
     * @return mixed
     */
    public function actionDelete($prospect_id, $preference_id)
    {
        $this->findModel($prospect_id, $preference_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProspectPreference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $prospect_id
     * @param integer $preference_id
     * @return ProspectPreference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($prospect_id, $preference_id)
    {
        if (($model = ProspectPreference::findOne(['prospect_id' => $prospect_id, 'preference_id' => $preference_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
