<?php
/**
 * This test covers the EloqueDatabase class :D
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Tests;


use Illuminate\Database\Capsule\Manager;

class EloquentDatabaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider databaseOptionsProvider
     */
    public function testInitSetsValidCapsuleObjectAndConnectionToDatabase($databaseOptions)
    {
        $container = (require 'src/config/services.php');
        $orm = $container->get('database');
        $orm->init($databaseOptions['databaseDriver']);
        $capsule = $orm->getCapsuleObject();

        $this->assertTrue($capsule instanceof Manager);
    }

    /**
     * @dataProvider databaseOptionsProvider
     */
    public function testGetConfigForActiveDriverGetsValidConfig($databaseOptions){
        $container = (require 'src/config/services.php');
        $orm = $container->get('database');
        $orm->init($databaseOptions['databaseDriver']);

        $activeDriversConfig = $orm->getConfigForActiveDriver();

        $this->assertTrue(is_array($activeDriversConfig));
        $this->assertTrue(isset($activeDriversConfig['driver']));
    }

    public function databaseOptionsProvider()
    {
        return [
            [
                [
                    'databaseConfig' => [
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
                        ]
                    ],
                    'databaseDriver' => 'mysql'
                ]
            ]
        ];
    }
}