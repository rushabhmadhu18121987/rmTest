<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => 'app\models\UserMaster',
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ]
            ]
        ]
    ],
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '647909932586-tfvqkv9gvinshncqt0scvq06vrkdajtc.apps.googleusercontent.com',
                    'clientSecret' => '_ie35WId4gSt0Dtp3TJJxuzu',
                ],
            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
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
        'urlManager' => [
            'enablePrettyUrl' => true, // Disable r= routes
            'showScriptName' => true, // Disable index.php
            'enableStrictParsing' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/static-page',
                    'tokens' => ['{slug}' => '<slug:[a-zA-Z0-9_\-]+>'],
                    'patterns' => [
                        'GET {slug}' => 'view',
                    ],
                ],
                'POST site/<action:\w+>' => 'site/rest/<action>',
                'POST v1/user-card/set-default-card' => 'v1/user-card/set-default-card/',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/categories', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/static-page', 'tokens' => ['{id}' => '<id:\\d+>'],],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user-card', 'tokens' => ['{id}' => '<id:\\d+>'], 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user-contact-us', 'tokens' => ['{id}' => '<id:\\d+>'], 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/app-setting', 'tokens' => ['{id}' => '<id:\\w+>'], 'pluralize' => false],
            ],
        ],
    ],
    'params' => $params,
];
