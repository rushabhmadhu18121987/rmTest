<?php

namespace backend\controllers;

use Yii;
use backend\models\EventMaster;
use backend\models\BannerMaster;
use backend\models\BusinessMaster;
use backend\models\BannerMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\base\BaseController;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\db\Transaction;

/**
 * BannersController implements the CRUD actions for BannerMaster model.
 */
class BannersController extends BaseController {

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
     * Lists all BannerMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BannerMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BannerMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->data['model'] = $this->findModel($id);
        return $this->render('view', $this->data);
    }

    /**
     * Creates a new BannerMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        $model = new BannerMaster();
        $model->scenario = SCH_CREATE;

        if ($model->load($this->bodyParams)) {
            $vBannerPic = UploadedFile::getInstance($model, 'vBannerPic');
            $model->vBannerPic = time() . '.' . $vBannerPic->extension;
            $model->tiIsActive = 1;
            $model->tiIsDeleted = 0;
            $model->iCreatedAt = time();
            if ($model->save()) {
                if (!empty($vBannerPic)) {
                    $dir = 'banner/' . $model->iBannerId;
                    Yii::$app->generallib->aws_s3_uplaod(['dir' => $dir, 'tmp_name' => $vBannerPic->tempName, 'type' => $vBannerPic->type, 'name' => $model->vBannerPic]);
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->iBannerId]);
            }
        }

        $this->data['model'] = $model;
        return $this->render('create', $this->data);
    }

    /**
     * Updates an existing BannerMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        $model = $this->findModel($id);
        $model->scenario = SCH_UPDATE;

        $oldPic = $model->vBannerPic;
        if ($model->load($this->bodyParams)) {
            $vBannerPic = UploadedFile::getInstance($model, 'vBannerPic');
            if (!empty($vBannerPic)) {
                $model->vBannerPic = time() . '.' . $vBannerPic->extension;
            } else {
                $model->vBannerPic = $oldPic;
            }
            $model->iCreatedAt = time();
            if ($model->save()) {
                if (!empty($vBannerPic)) {
                    $dir = 'banner/' . $model->iBannerId;
                    Yii::$app->generallib->aws_s3_uplaod(['dir' => $dir, 'tmp_name' => $vBannerPic->tempName, 'type' => $vBannerPic->type, 'name' => $model->vBannerPic]);
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->iBannerId]);
            }
        }

        $this->data['iEntryData'] = ['id' => '1', 'text' => 'abc'];
        $this->data['model'] = $model;
        return $this->render('update', $this->data);
    }

    /**
     * Deletes an existing BannerMaster model.
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
     * Finds the BannerMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BannerMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BannerMaster::findOne($id)) !== null) {
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

    public function actionSearchEntry() {
        try {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            $input = \Yii::$app->request->queryParams;
            if (!empty($input['tiBannerType']) && $input['tiBannerType'] == 1) {
                $business = BusinessMaster::find()
                                ->select(['iBusinessId as id', 'vBusinessName AS text'])
                                ->andWhere(['LIKE', 'vBusinessName', $input['searchTerm'] ?? ''])
                                ->asArray()->all();
                $out = ['results' => $business];
            } else if (!empty($input['tiBannerType']) && $input['tiBannerType'] == 2) {
                $events = EventMaster::find()
                                ->select(['iEventId as id', 'vTitle AS text'])
                                ->andWhere(['LIKE', 'vTitle', $input['searchTerm'] ?? ''])
                                ->asArray()->all();
                $out = ['results' => $events];
            }
            return $out;
        } catch (\Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
