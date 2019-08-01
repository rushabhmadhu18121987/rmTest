<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qotxgK7bYW7W4fXUUpKzzARVXje6keNR',
        ],
    ],
];
if (!YII_ENV_TEST) {
    // configuration adjustments for 'local' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
//    $config['bootstrap'][] = 'swagger';
//    $config['modules']['swagger'] = [
//        'class' => 'mobidev\swagger\Module',
//        'jsonPath' => '@api/web/swagger-dev.json',
//        'host' => '172.16.17.178',
//        'basePath' => '/v1',
//        'description' => 'My Project API documentation (swagger-2.0 specification)',
//        'defaultInput' => 'body',
//    ];
}
return $config;
