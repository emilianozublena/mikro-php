<?php
/**
 * Base abstract class for any database implementation. It can be a plain PDO implementation or any given full ORM
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Core;

use Interop\Container\ContainerInterface;

abstract class Database
{
    protected $config, $container, $activeDriver;

    function __construct(ContainerInterface $container, array $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * If theres a new driver, this function checks that the string is not empty
     * The string also should be a key of the config given
     * And also the driver given has to be something different than the activeDriver (defaultDriver)
     * @param $driver
     * @return bool
     */
    protected function isNewDriverValid($driver)
    {
        return $driver !== '' && isset($this->config[$driver]) && $driver !== $this->activeDriver;
    }

    protected function setNewDriver($driver)
    {
        $this->activeDriver = $driver;
    }

    abstract public function init();

    abstract protected function isConfigValid();
}