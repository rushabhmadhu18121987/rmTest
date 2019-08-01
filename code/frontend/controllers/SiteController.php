<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\UserMaster;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['reset-password'],
                'rules' => [
                    [
                        'actions' => ['reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionSignup() {
        $model = new \frontend\models\SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @author Sameer Paghdar <sameerp.spaceo@gmail.com>
     */
    public function actionResetPassword($token) {
        $this->layout = 'guest';
        $status = 0;
        $message = 'Your reset password token is invalid or maybe expire.';
        if (!empty($token)) {
            $model = UserMaster::findByPasswordResetToken($token);
            if (!empty($model)) {
                $status = 1;
                $model->scenario = 'reset_password';
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $model->vPassword = md5($model->vPassword);
                    $model->confirmPassword = md5($model->confirmPassword);
                    $model->vPasswordResetToken = NULL;
                    if ($model->save()) {
                        $status = 2;
                        $message = 'New password was saved.';
                    } else {
                        $message = 'Sorry, we are unable to reset your password.';
                    }
                }
            }
        }
        return $this->render('resetPassword', [
                    'model' => $model,
                    'status' => $status,
                    'message' => $message
        ]);
    }

}
