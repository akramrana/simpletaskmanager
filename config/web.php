<?php

use yii\web\Request;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$functions = require __DIR__ . '/functions.php';
$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());

$config = [
    'id' => 'basic',
    'name' => 'Simple Task Manager',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'OK4-G4UomWFcOG3cq7YQDj4sLehrsaa8',
            'baseUrl' => $baseUrl,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                'POST api/task' => 'api/task/create',
                'GET,HEAD api/task' => 'api/task/index',
                'GET,HEAD api/task/<id>' => 'api/task/view',
                'PUT,PATCH api/task/<id>' => 'api/task/update',
                'DELETE api/task/<id>' => 'api/task/delete',
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /* $config['bootstrap'][] = 'debug';
      $config['modules']['debug'] = [
      'class' => 'yii\debug\Module',
      // uncomment the following to add your IP if you are not connecting from localhost.
      //'allowedIPs' => ['127.0.0.1', '::1'],
      ]; */

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
