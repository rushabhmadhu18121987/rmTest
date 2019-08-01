<?php

namespace backend\controllers;

use Yii;
use backend\models\CategoryMaster;
use backend\models\CategoryMasterSearch;
use backend\controllers\base\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\db\Transaction;

/**
 * CategoryMasterController implements the CRUD actions for CategoryMaster model.
 */
class CategoryMasterController extends BaseController {

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
     * Lists all CategoryMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CategoryMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CategoryMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->data['model'] = $this->findModel($id);
        return $this->render('view', $this->data);
    }

    /**
     * Creates a new CategoryMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        $model = new CategoryMaster();
        $model->scenario = SCH_CREATE;

        if ($model->load($this->bodyParams)) {
            $vCategoryIcon = UploadedFile::getInstance($model, 'vCategoryIcon');
            $model->vCategoryIcon = time() . '.' . $vCategoryIcon->extension;
            $model->tiIsActive = 1;
            $model->tiIsDeleted = 0;
            $model->iCreatedAt = time();
            if ($model->save()) {
                if (!empty($vCategoryIcon)) {
                    $dir = 'category/' . $model->iCategoryId;
                    Yii::$app->generallib->aws_s3_uplaod(['dir' => $dir, 'tmp_name' => $vCategoryIcon->tempName, 'type' => $vCategoryIcon->type, 'name' => $model->vCategoryIcon]);
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->iCategoryId]);
            }
        }
        $this->data['model'] = $model;
        return $this->render('create', $this->data);
    }

    /**
     * Updates an existing CategoryMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        $model = $this->findModel($id);
        $model->scenario = SCH_UPDATE;
        if ($model->load($this->bodyParams)) {
            $vCategoryIcon = UploadedFile::getInstance($model, 'vCategoryIcon');
            if (!empty($vCategoryIcon)) {
                $model->vCategoryIcon = time() . '.' . $vCategoryIcon->extension;
            }
            $model->iUpdatedAt = time();
            if ($model->save()) {
                if (!empty($vCategoryIcon)) {
                    $dir = 'category/' . $model->iCategoryId;
                    Yii::$app->generallib->aws_s3_uplaod(['dir' => $dir, 'tmp_name' => $vCategoryIcon->tempName, 'type' => $vCategoryIcon->type, 'name' => $model->vCategoryIcon]);
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->iCategoryId]);
            }
        }
        $this->data['model'] = $model;
        return $this->render('update', $this->data);
    }

    /**
     * Deletes an existing CategoryMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->tiIsDeleted = 1;
        $model->iUpdatedAt = time();
        $model->save();
        Yii::$app->session->setFlash('success', \Yii::t('admin', 'category_delete_success'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the CategoryMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CategoryMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }

    public function actionStatusChange($id, $type) {
        $model = $this->findModel($id);
        $model->tiIsActive = $type;
        $model->save();
        return $this->redirect(['index']);
    }

}
