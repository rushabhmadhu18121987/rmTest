<?php

use \yii\web\Request;

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php'
);

return [
    'id' => 'appway-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'rbac' => [
            'class' => 'yii2mod\rbac\Module',
        ],
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module'
        ],
    ],
    'components' => [
       'request' => [
            'csrfParam' => '_csrf-nearby-backend',
            'baseUrl' => str_replace('/web', '', (new Request)->getBaseUrl()),
        ],
        'user' => [
            'identityClass' => 'backend\models\AdminMaster',
            'enableAutoLogin' => true,
            //'authTimeout' => 172800, // 48 hour
            'identityCookie' => ['name' => '_identity-appway-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'appway-backend',
        //'savePath' => sys_get_temp_dir(),
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                '/' => 'site/index',
                'logout' => 'site/logout',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/event', 'tokens' => ['{id}' => '<id:[0-9,]+>'], 'pluralize' => false],
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'params' => $params,
];
