<?php

return [
    'name' => 'Veebo',
    'timeZone' => 'UTC',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => 'ne',
        ],
        'generallib' => [
            'class' => 'common\components\Generallib',
        ],
        'apptransaction' => [
            'class' => 'common\components\Transactions',
        ],
        'common' => [
            'class' => 'common\components\Common',
        ],
        'social' => [
            'class' => 'common\components\Social',
        ],
        'braintree' => [
            'class' => 'bryglen\braintree\Braintree',
            'environment' => 'sandbox',
            'merchantId' => 'm9mqy5yst84dqnyv',
            'publicKey' => 'dnsjt42zybw9nx5p',
            'privateKey' => '43465b3a6572e5e8648ddffc0f03ab59'
        ],
        'formatter' => [
            'dateFormat' => 'dd MMM yyyy',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyCode' => 'USD',
        ],
        'i18n' => [
            'translations' => [
                'title' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'label' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'response' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'notification' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
    ],
];
