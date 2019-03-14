<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

return [
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => yii\i18n\DbMessageSource::class,
                    'db' => 'db',
                    'sourceLanguage' => 'en-US',
                    'sourceMessageTable' => '{{%language_source}}',
                    'messageTable' => '{{%language_translate}}',
                    'cachingDuration' => 0,
                    'enableCaching' => false
                ]
            ]
        ],
        'db' => $db,
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
            'defaultRoles' => ['guest']
        ]
    ],
    'modules' => [
        'translatemanager' => [
            'class' => lajax\translatemanager\Module::class,
            'root' => '@app',
            'tmpDir' => '@runtime',
            'ignoredCategories' => ['yii'],
            'allowedIPs' => ['*'],
            'ignoredItems' => [
                '.svn',
                '.git',
                '.gitignore',
                '.gitkeep',
                '.hgignore',
                '.hgkeep',
                '/messages',
                '/BaseYii.php',
                'runtime',
                'bower',
                'nikic',
                '/vendor',
                '.idea'
            ],
            'tables' => [
                [
                    'connection' => 'db',
                    'table' => '{{%products}}',
                    'columns' => ['title']
                ]
            ]
        ]
    ],
    'params' => $params,
    'controllerMap' => []
];
