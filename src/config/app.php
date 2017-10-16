<?php
/**
 * This file contains an array with the configurations needed for an app using this micro fw.
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

return [
    'baseUrl' => 'http://localhost/mikro',
    'databases' => [
        'config' => [
            'mysql' => [
                'driver'      => 'mysql',
                'host'        => '127.0.0.1',
                'port'        => '3306',
                'database'    => 'mikro',
                'username'    => 'root',
                'password'    => 'root',
                'unix_socket' => '',
                'charset'     => 'utf8',
                'collation'   => 'utf8_unicode_ci',
                'prefix'      => '',
                'strict'      => true,
                'engine'      => null,
            ],
        ]
    ]
];