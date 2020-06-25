<?php

return [
    'user' => [
        // enable cookie-based authentication
        'allowAutoLogin' => true,
    ],
    'urlManager' => [
        'urlFormat' => 'path',
        'urlSuffix' => '/',
        'showScriptName' => false,
        'rules' => require(__DIR__ . '/rules.php'),
    ],
    'db' => require(__DIR__ . '/database.php'),

    'errorHandler' => [
        'errorAction' => YII_DEBUG ? null : 'base/error',
    ],

    'log' => [
        'class' => 'CLogRouter',
        'routes' => [
            [
                'class' => 'CFileLogRoute',
                'levels' => 'error, warning',
            ],
//            [
//                'class' => 'CWebLogRoute',
//            ],
        ],
    ],

];