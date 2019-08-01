<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller {

    /**
     * {@inheritdoc}
     */
    /* public function behaviors()
      {
      return [
      'access' => [
      'class' => AccessControl::className(),
      'rules' => [
      [
      'actions' => ['login', 'error'],
      'allow' => true,
      ],
      [
      'actions' => ['logout', 'index'],
      'allow' => true,
      'roles' => ['@'],
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
      } */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'authenticator' => [
                        'class' => CompositeAuth::className(),
                        'authMethods' => [
                            ['class' => HttpBearerAuth::className()],
                            ['class' => QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
                        ]
                    ],
                    'exceptionFilter' => [
                        'class' => ErrorToExceptionFilter::className()
                    ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
//            'docs' => [
//                'class' => 'yii2mod\swagger\SwaggerUIRenderer',
//                'restUrl' => Url::to(['site/json-schema']),
//            ],
            'json-schema' => [
                'class' => 'yii2mod\swagger\OpenAPIRenderer',
                // Тhe list of directories that contains the swagger annotations.
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

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

}
