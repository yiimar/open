<?php

return [
    'import',
    'gii' => [
        'class'=>'system.gii.GiiModule',
        'password'=>'111',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        'ipFilters' => ['127.0.0.1','::1'],
    ],
];