<?php
/**
 * This class is responsible for initiating our Eloquent instance
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentDatabase extends Database
{
    private $capsule;
    protected $activeDriver = 'mysql';

    /**
     * This simple interface function is just for handling a single entry point for initiating our Databases
     * @param string $driver
     */
    public function init($driver = '')
    {
        if ($this->isNewDriverValid($driver)) {
            $this->setNewDriver($driver);
        }
        $this->initORM($this->container->get('capsule'));
    }

    /**
     * Here we have the specific implementation for using our Eloquent ORM,
     * If you choose to use something else, this function would be different ;)
     * @param Capsule $capsule
     */
    private function initORM(Capsule $capsule)
    {
        if ($this->isConfigValid()) {

            $capsule->addConnection(
                $this->getConfigForActiveDriver()
            );

            $capsule->setAsGlobal();

            $capsule->bootEloquent();

            $this->capsule = $capsule;
        }
    }

    public function getConfigForActiveDriver()
    {
        return $this->config[$this->activeDriver];
    }

    /**
     * Checks if the given config has any items inside
     * @return bool
     */
    protected function isConfigValid()
    {
        return count($this->config) > 0;
    }

    public function getCapsuleObject()
    {
        return $this->capsule;
    }

}