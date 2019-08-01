<?php

namespace backend\controllers;

use Yii;
use backend\models\ContentPages;
use backend\models\ContentPagesSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\base\BaseController;

/**
 * ContentPagesController implements the CRUD actions for ContentPages model.
 */
class ContentPagesController extends BaseController {

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
                        'controllers' => ['content-pages'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'delete-page', 'status-change'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                    // other rules
                    ],
                ], // rules
            ], // access
        ];
    }

    /**
     * Lists all ContentPages models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ContentPagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ContentPages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ContentPages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ContentPages();

        if ($model->load(Yii::$app->request->post())) {
            $model->iCreatedAt = time();
            $model->tiIsActive = 1;
            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                print_R($model->errors);
                die;
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ContentPages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->iUpdatedAt = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDeletePage() {
        $model = $this->findModel($_POST['iPageId']);

        if ($model->delete()) {
            $response = ['response_status' => 200];
        } else {
            $response = ['response_status' => 400];
        }
        echo json_encode($response);
        die();
    }

    /**
     * Deletes an existing ContentPages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ContentPages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContentPages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ContentPages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStatusChange($id, $type) {
        $model = $this->findModel($id);
        $model->tiIsActive = $type;
        $model->save();
        return $this->redirect(['index']);
    }

}
