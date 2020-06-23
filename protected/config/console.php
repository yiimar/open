<?php

$dir = __DIR__ . DIRECTORY_SEPARATOR;
require_once ($dir . '../helpers/global.php');

$config = [
    // autoloading model and component classes
    'aliases'    => require ($dir . 'aliases.php'),
    'params'     => require ($dir . 'params.php'),
    'import'     => require ($dir . 'import.php'),
    'modules'    => [],

    'basePath' => $dir . '..',

    // preloading 'log' component
    'preload'   => ['log'],

    // application components
    'components'=> [
        'db' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;dbname=open',
            'emulatePrepare' => true,
            'username' => 'admin',
            'password' => '111',
            'charset' => 'utf8',
        ],//require($dir .'database.php'),

        'log' => [
            'class'  => 'CLogRouter',
            'routes' => [
                [
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
            ],
        ],
    ],
];
return $config;
