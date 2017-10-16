<?php
/**
 * This factory creates a new instance of EloquentDatabase
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Utils\Factories;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Mikro\Core\EloquentDatabase;
use Mikro\Http\Kernel;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class EloquentDatabaseFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = (require __DIR__ . '/../../config/app.php');
        return new EloquentDatabase($container, $config['databases']['config']);
    }
}