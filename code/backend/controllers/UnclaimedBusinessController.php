<?php

namespace backend\controllers;

use Yii;
use backend\models\UnclaimedBusiness;
use backend\models\UnclaimedBusinessSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\base\BaseController;

/**
 * UnclaimedBusinessController implements the CRUD actions for UnclaimedBusiness model.
 */
class UnclaimedBusinessController extends BaseController {

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
        ];
    }

    /**
     * Lists all UnclaimedBusiness models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UnclaimedBusinessSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->data['searchModel'] = $searchModel;
        $this->data['dataProvider'] = $dataProvider;
        return $this->render('index', $this->data);
    }

    /**
     * Displays a single UnclaimedBusiness model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->data['model'] = $this->findModel($id);
        return $this->render('view', $this->data);
    }

    /**
     * Creates a new UnclaimedBusiness model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new UnclaimedBusiness();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iBusinessId]);
        }

        $this->data['model'] = $model;
        return $this->render('create', $this->data);
    }

    /**
     * Updates an existing UnclaimedBusiness model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iBusinessId]);
        }

        $this->data['model'] = $model;
        return $this->render('update', $this->data);
    }

    /**
     * Deletes an existing UnclaimedBusiness model.
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
     * Finds the UnclaimedBusiness model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UnclaimedBusiness the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $model = UnclaimedBusiness::find()
                ->select(['business_master.*', 'cm.vCategoryName', 'um.vName'])
                ->leftJoin('user_master um', 'um.iUserId = business_master.iUserId')
                ->leftJoin('category_master cm', 'cm.iCategoryId = business_master.iCategoryId')
                ->where(['business_master.iBusinessId' => $id])->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }

}
