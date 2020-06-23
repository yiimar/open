<?php
return [
    '/'                                => 'base/list',

    '<m:\w+>/<c:\w+>/<a:\w+>/<id:\d+>' => '<m>/<c>/<a>',
    '<m:\w+>/<c:\w+>/<a:\w+>'          => '<m>/<c>/<a>',
    '<m:\w+>/<c:\w+>'                  => '<m>/<c>/index',

    '<c:\w+>/<id:\d+>'                 => '<c>/view',
    '<c:\w+>/<a:\w+>/<id:\d+>'         => '<c>/<a>',
    '<c:\w+>/<a:\w+>'                  => '<c>/<a>',
];