<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php')

);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            'format' => 'json'
        ],
        'urlManager' => [
            'class' => \yii\web\UrlManager::class,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'lottery' => 'lottery/lottery',
                    ],
                    'pluralize' => false,
                    'patterns' => [
                        'GET,HEAD {lotteryId}' => 'get-participants',
                        'GET,HEAD {playerUUID}' => 'get-participant-by-id',
                    ],
                    'tokens' => [
                        '{lotteryId}' => '<lotteryId:\\d[\\d,]*>/participants',
                        '{playerUUID}' => '<lotteryId:\\d[\\d,]*>/participants/<playerUUID:\\d[\\d,]*>',
                    ]
                ],
            ]
        ],
        'user' => [
            'identityClass' => false,
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],
    ],
    'params' => $params,
    'modules' => [
        'lottery' => api\modules\lottery\Module::class
    ]
];
