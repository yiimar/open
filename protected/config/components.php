<?php

return [
    'user'=>[
        // enable cookie-based authentication
        'allowAutoLogin'=>true,
    ],
    'urlManager'=>[
        'urlFormat'=>'path',
        'showScriptName'=>false,
        'rules'=>[
            '<controller:\w+>/<id:\d+>'=>'<controller>/view',
            '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        ],
    ],
    'db'=>require(__DIR__.'/database.php'),

    'errorHandler'=>[
        'errorAction'=>YII_DEBUG ? null : 'site/error',
    ],

    'log'=>[
        'class'=>'CLogRouter',
        'routes'=>[
            [
                'class'=>'CFileLogRoute',
                'levels'=>'error, warning',
            ],
            [
                'class'=>'CWebLogRoute',
            ],
        ],
    ],

];