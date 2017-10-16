<?php
/**
 * Abstract factory for every controller
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Utils\Factories;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class ControllersAbstractFactory implements AbstractFactoryInterface
{


    /**
     * Checks if the requested name implements or extends our Controller abstract class
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return (
            in_array('\Mikro\Http\Controllers\Controller', class_implements($requestedName), true) ||
            is_subclass_of($requestedName, '\Mikro\Http\Controllers\Controller')
        );
    }

    /**
     * Every controller has to be injected with both Request and the Container itself
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
        $request = $container->get('request');
        $view = $container->get('view');
        return new $requestedName($container, $request, $view);
    }
}