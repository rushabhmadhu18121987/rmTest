<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Passwordresetrequestform;
use backend\models\ResetPasswordForm;
use yii\helpers\Url;
use common\models\DeviceMaster;
use yii\base\InvalidParamException;
use backend\controllers\base\BaseController;
use backend\models\AdminMaster;
use backend\models\ContactUs;
use backend\models\UnclaimedBusiness;

use common\models\UserMaster;
use common\models\VendorMaster;

/**
 * Site controller
 */
class SiteController extends BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'backgroundscript', 'docs', 'json-schema', 'requestresetpassword', 'reset-password', 'user-reset-password', 'change-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'docs' => [
                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
                'restUrl' => Url::to(['site/json-schema']),
            ],
            'json-schema' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                'scanDir' => [
                    Yii::getAlias('@api/modules/v1/controllers'),
                    Yii::getAlias('@api/modules/v1/models'),
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        // Primary Counter
        $this->data['userMasterCount'] = UserMaster::find()->where(['tiIsDeleted'=>0])->count();
        $this->data['vendorMasterCount'] = VendorMaster::find()->where(['tiIsDeleted'=>0])->count();
        return $this->render('index', $this->data);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {

        $this->layout = 'guest';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $_SESSION['user_id'] = $model['user']['id'];

            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionBackgroundscript() {
        set_time_limit(0);
        header("Connection: close");
        ignore_user_abort(true);
        $modelDevice = DeviceMaster::find()
                ->select(['vDeviceToken', 'eDeviceType', 'iUserId'])
                ->all();
        $messageArr = $_REQUEST;
        $msgData = json_decode($messageArr['jsonData'], true);
        Yii::$app->generallib->send_push($modelDevice, ['msg' => $msgData['message'], 'type' => 'sendThankYou']);
    }

    /*  reset password action */

    public function actionRequestresetpassword() {
        $this->layout = 'guest';
        $model = new Passwordresetrequestform();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {

                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {

                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestresetpasswod', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        $this->layout = 'guest';

        try {

            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {

            return $this->render('error', ['name' => 'Bad Request', 'message' => $e->getMessage()]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect('index');
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionUserResetPassword($token) {
        $this->layout = 'guest';

        $model = \backend\models\UserMaster::find()->where(['vPasswordResetToken' => $token])->one();
        if (empty($model)) {
            return $this->render('error', ['name' => 'Bad Request', 'Invalid Token']);
        } else {
            $model->scenario = \backend\models\UserMaster::RESET_PASSWORD;
            if ($model->load(Yii::$app->request->post())) {
                $model->vPassword = md5($model->password);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'New password saved.');
                }
                Yii::$app->session->setFlash('error', 'error while saving password');
            }
        }
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionChangePassword() {
        $model = AdminMaster::findIdentity(Yii::$app->user->identity->id);
        $model->scenario = SCH_CHANGE_PASSWORD;
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->validatePassword($model->currentPassword)) {
                $model->addError('currentPassword', "Current password is not valid.");
            } else {
                $hash = Yii::$app->getSecurity()->generatePasswordHash($model->newPassword);
                $model->password_hash = $hash;
                $model->updated_at = time();
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('response', 'change_password_success'));
                    $this->goHome();
                }
            }
        }
        return $this->render('change-password', ['model' => $model,]);
    }

}
