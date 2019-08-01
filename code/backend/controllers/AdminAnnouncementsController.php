<?php

namespace backend\controllers;

use Yii;
use backend\models\AdminAnnouncements;
use backend\models\AdminAnnouncementsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Transaction;
use backend\controllers\base\BaseController;
use common\models\UserMaster;

/**
 * AdminAnnouncementsController implements the CRUD actions for AdminAnnouncements model.
 */
class AdminAnnouncementsController extends BaseController {

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
     * Lists all AdminAnnouncements models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminAnnouncementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminAnnouncements model.
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
     * Creates a new AdminAnnouncements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AdminAnnouncements();
        $model->scenario = SCH_CREATE;
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);

        if ($model->load(Yii::$app->request->post())) {
            $model->iCreatedAt = time();
            if ($model->save()) {
                $query = UserMaster::find()->where(['tiIsDeleted' => 0, 'tiIsActive' => 1]);
                if ($model->tiNotificationReceiver == 1 || $model->tiNotificationReceiver == 2) {
                    $query = $query->andWhere(['IN', 'iUserId', $model->iUsers]);
                } else if ($model->tiNotificationReceiver == 3) {
                    $query = $query->andWhere(['tiUserType' => 1]);
                } else if ($model->tiNotificationReceiver == 4) {
                    $query = $query->andWhere(['tiUserType' => 2]);
                }
                $users = $query->all();
                if (!empty($users)) {
                    $receiverData = [];
                    foreach ($users as $key => $user) {
                        $receiverData[] = [
                            'iAnnouncementId' => $model->iAnnouncementId,
                            'iUserId' => $user->iUserId,
                            'iCreatedAt' => time()
                        ];
                    }
                    Yii::$app->db->createCommand()
                            ->batchInsert('admin_announcement_receiver', ['iAnnouncementId', 'iUserId', 'iCreatedAt'], $receiverData)
                            ->execute();
//                    $model->sendNotification();
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Announcement has been sent successfully.');
                return $this->redirect(['index']);
            }
        }
        if (empty(Yii::$app->request->post())) {
            $model->tiNotificationReceiver = 0;
        }

        $this->data['model'] = $model;
        return $this->render('create', $this->data);
    }

    /**
     * Deletes an existing AdminAnnouncements model.
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
     * Finds the AdminAnnouncements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminAnnouncements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AdminAnnouncements::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSearchUser() {
        try {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            $input = \Yii::$app->request->queryParams;
            if (!empty($input['tiUserType'])) {
                $users = UserMaster::find()
                                ->select(['iUserId as id', 'CONCAT(vName," (",vEmail,")") AS text'])
                                ->where(['tiUserType' => $input['tiUserType'], 'tiIsDeleted' => 0, 'tiIsActive' => 1])
                                ->andWhere(['LIKE', 'CONCAT(vName," (",vEmail,")")', $input['searchTerm'] ?? ''])
                                ->asArray()->all();
                $out = ['results' => $users];
            }
            return $out;
        } catch (\Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
