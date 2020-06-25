<?php

// подробнее про index.php http://www.yiiframework.ru/doc/guide/ru/basics.entry
if (!ini_get('date.timezone')) {
    date_default_timezone_set('UTC');
}

ini_set('display_errors', 'On');
error_reporting(E_ALL);


$config = __DIR__.'/../protected/config/main.php';

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii/framework/yii.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

Yii::createWebApplication($config)->run();
