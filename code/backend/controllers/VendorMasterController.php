<?php

namespace backend\controllers;

use Yii;
use common\models\VendorMaster;
use common\models\VendorMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\base\BaseController;
use moonland\phpexcel\Excel;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * VendorMasterController implements the CRUD actions for VendorMaster model.
 */
class VendorMasterController extends BaseController
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'upload-csv' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all VendorMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VendorMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tiIsDeleted'=>0]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VendorMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VendorMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VendorMaster();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->vPassword = md5('123456');
            $model->iCreatedAt = time();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->iVendorId]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VendorMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->iUpdatedAt = time();
            
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->iVendorId]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VendorMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model !== null) {
            $model->tiIsDeleted = 1;
            $model->iUpdatedAt = time();
            $model->save();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the VendorMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VendorMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VendorMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStatusChange($id, $type) {
        $model = $this->findModel($id);
        $model->tiIsActive = $type;
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionUploadCsv()
    {
        $model = new VendorMaster();
        $model->load(Yii::$app->request->post(), '');
        if (Yii::$app->request->post()) {
            $img_upload = UploadedFile::getInstanceByName('profile');
            echo "<pre>";
            print_r($img_upload);
        }
        die;
        
        $fileName = Yii::getAlias('@uploads').'/excels/example.xlsx';
        if(!file_exists($fileName)){
            echo 'File Not Found'; 
            return;
        }
        $data = Excel::import($fileName, [
            'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
            'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
            'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
        ]);
        echo "<pre>";
        print_r($data);
    }
}
