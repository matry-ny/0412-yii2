<?php

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'request' => \app\components\request\cli\CliRequest::class,
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ],
    ],
    'controllerMap' => [
        'translate' => \lajax\translatemanager\commands\TranslatemanagerController::class
    ]
];

return $config;
