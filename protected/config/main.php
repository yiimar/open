<?php

$dir = __DIR__ . DIRECTORY_SEPARATOR;
require_once ($dir . '../helpers/global.php');

$config = [
    // autoloading model and component classes
    'aliases'    => require ($dir . 'aliases.php'),
    'import'     => require ($dir . 'import.php'),
    'modules'    => require ($dir . 'modules.php'),
    'components' => require ($dir . 'components.php'),
    'params'     => require ($dir . 'params.php'),

    'basePath' => $dir . '..',
	'name' => 'Import for "OPEN"',

	'preload' => [
	    'log',
        'bootstrap',
    ],

    'sourceLanguage' => 'ru',
    'language'       => 'ru',
];

return $config;
