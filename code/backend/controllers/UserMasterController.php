<?php

namespace backend\controllers;

use Yii;
use common\models\UserMaster;
use common\models\UserMasterSearch;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\base\BaseController;

/**
 * UserMasterController implements the CRUD actions for UserMaster model.
 */
class UserMasterController extends BaseController {

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
                        'controllers' => ['user-master'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'status-change','sendmail','import-csv'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ], // rules
            ], // access
        ];
    }


    public function beforeAction($action)
    {            
        if ($action->id == 'import-csv') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
    /**
     * Lists all UserMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->data['model'] = $this->findModel($id);
        return $this->render('view', $this->data);
    }

    /**
     * Creates a new UserMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new UserMaster();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {            
            try{
                $vProfilePic = UploadedFile::getInstance($model, 'vProfilePic');
                // echo "<pre>";
                // print_r($vProfilePic);
                // die;
                $model->vProfilePic = time() . '.' . $vProfilePic->extension;                              
                if (!empty($vProfilePic)) {

                    $vProfilePic->saveAs('uploads/users/' . $model->vProfilePic);
/* 
    Below code is commented for upload image on s3 bucket
 */                   
                    // $dir = Yii::$app->params['USER_PROFILE'];
                    // Yii::$app->s3helper->uploadFileS3bucket(
                    //                     [
                    //                         'dir' => $dir, 
                    //                         'tmp_name' => $vProfilePic->tempName, 
                    //                         'type' => $vProfilePic->type, 
                    //                         'name' => $model->vProfilePic
                    //                     ]   
                    //                 );
                }

                $model->vPassword = md5('12345678');
                $model->iCreatedAt = time();
                if($model->save()){
                    $to =  Yii::$app->request->post('vEmail');
                    $from = Yii::$app->params['DEVELOPER_EMAIL'];
                    Yii::$app->generallib->sendEmail($to, $from, $subject, $body);
                    $data = json_encode($model);
                    Yii::$app->generallib->clouderrorlog($data);                    
                    return $this->redirect(['view', 'id' => $model->iUserId]);
                }
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
        $this->data['model'] = $model;
        return $this->render('create', $this->data);
    }

    /**
     * Updates an existing UserMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->isNewRecord = false;
        $exist_image = $model->vProfilePic;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try{
                $vProfilePic = UploadedFile::getInstance($model, 'vProfilePic');
                
                if(!empty($vProfilePic)){
                    // print_r('if ma ave 6e');die;   
                    $model->vProfilePic = time() . '.' . $vProfilePic->extension;                              
                    if (!empty($vProfilePic)) {

                        $vProfilePic->saveAs('uploads/users/' . $model->vProfilePic);
    /* 
        Below code is commented for upload image on s3 bucket
    */                   
                        // $dir = Yii::$app->params['USER_PROFILE'];
                        // Yii::$app->s3helper->uploadFileS3bucket(
                        //                     [
                        //                         'dir' => $dir, 
                        //                         'tmp_name' => $vProfilePic->tempName, 
                        //                         'type' => $vProfilePic->type, 
                        //                         'name' => $model->vProfilePic
                        //                     ]   
                        //                 );
                    }                
                } else {                    
                    $model->vProfilePic = $exist_image;
                }
                $model->iUpdatedAt = time();
                if($model->save()){             
                    $data = json_encode($model);
                    Yii::$app->generallib->clouderrorlog($data);
                    return $this->redirect(['view', 'id' => $model->iUserId]);
                }
            }catch(\Exception $e){
                return $e->getMessage();
            }            
        }

        $this->data['model'] = $model;
        return $this->render('update', $this->data);
    }

    /**
     * Deletes an existing UserMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        // $model->scenario = SCH_DELETE;
        // Implements Soft Delete
        $model->tiIsDeleted = 1;
        $model->iUpdatedAt = time();
        $model->save(); 
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserMaster::findOne($id)) !== null) {
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

    /**
     * Creates a new UserMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSendmail() {        

        $data = Yii::$app->generallib->sendEmail('Testing','This is test email from basecode');
    }


    public function actionImportCsv(){
        try{
            print_r($_FILES);
            print_R('ave 6e');die;
        }catch(\Exception $e){
            $e->getMessage();
        }        

    }

}
