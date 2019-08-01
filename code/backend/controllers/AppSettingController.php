<?php

namespace backend\controllers;

use Yii;
use backend\models\AppSetting;
use backend\models\AppSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\base\BaseController;

/**
 * AppSettingController implements the CRUD actions for AppSetting model.
 */
class AppSettingController extends BaseController {

    /**
     * {@inheritdoc}
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
                        'controllers' => ['app-setting'],
                        'actions' => ['index', 'view', 'update'/* , 'app-setting-value-update' */],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ], // rules
            ], // access
        ];
    }

    /**
     * Lists all AppSetting models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AppSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppSetting model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AppSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AppSetting();
        $model->iCreatedAt = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iAppSettingId]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AppSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->iUpdatedAt = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iAppSettingId]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionAppSettingValueUpdate() {

        $postData = Yii::$app->request->post();
        if (Yii::$app->request->isAjax) {
            if (isset($postData['iAppSettingId'])) {
                $command = Yii::$app->db->createCommand('UPDATE `app_setting` SET `vAppSettingValue`=' . $postData['vAppSettingValue'] . ' ,`iUpdatedAt`=' . time() . ' WHERE `iAppSettingId`=' . $postData['iAppSettingId'] . '');
                $command->execute();
            }
        } else {
            
        }
    }

    /**
     * Deletes an existing AppSetting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AppSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AppSetting::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
