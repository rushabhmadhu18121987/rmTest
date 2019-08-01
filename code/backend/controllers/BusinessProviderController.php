<?php

namespace backend\controllers;

use Yii;
use backend\models\BusinessProvider;
use backend\models\BusinessProviderSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\base\BaseController;

/**
 * BusinessProviderController implements the CRUD actions for BusinessProvider model.
 */
class BusinessProviderController extends BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => ['business-provider'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'status-change'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ], // rules
            ], // access
        ];
    }

    /**
     * Lists all BusinessProvider models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BusinessProviderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BusinessProvider model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->data['model'] = $this->findModel($id);
        return $this->render('view', $this->data);
    }

    /**
     * Creates a new BusinessProvider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BusinessProvider();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iUserId]);
        }
        $this->data['model'] = $model;
        return $this->render('create', $this->data);
    }

    /**
     * Updates an existing BusinessProvider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iUserId]);
        }

        $this->data['model'] = $model;
        return $this->render('update', $this->data);
    }

    /**
     * Deletes an existing BusinessProvider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->scenario = SCH_DELETE;
        // Implements Soft Delete
        $model->tiIsDeleted = 1;
        $model->iUpdatedAt = time();
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the BusinessProvider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BusinessProvider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BusinessProvider::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionStatusChange($id, $type) {
        $model = $this->findModel($id);
        $model->tiIsActive = $type;
        $model->save();
        return $this->redirect(['index']);
    }

}
