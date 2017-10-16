<?php
/**
 * This class is the very core of the mikro. It works as a wrapper of several other libraries
 * Uses the ServiceManager (zend IoC container implementation) for preping all objects
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Http;

use Interop\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    private $coreServices = [
        'router',
        'request',
        'response',
        'database'
    ];

    private $config, $container, $router, $database, $dispatcher;

    function __construct(ContainerInterface $container, array $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * Gets all of core's defined services from the container.
     * It also checks if the services have a "init" method, if so, executes it.
     */
    public function initCore()
    {
        foreach ($this->coreServices as $service) {
            $this->{$service} = $this->container->get($service);
            if (method_exists($this->{$service}, 'init')) {
                $this->{$service}->init();
            }
        }
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Gets all routes from Router and passes them to the FastRoute dispatcher
     */
    public function processRoutes()
    {
        $routes = $this->router->getRoutes();
        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) use ($routes) {
            foreach ($routes as $route) {
                $r->{$route['httpMethod']}($route['route'], $route['handler']);
            }
        });
        $this->dispatcher = $dispatcher;
    }

    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * When the Kernel is run, the routes get dispatched and handlers get called.
     * This should be the exit point of the app always
     */
    public function run()
    {
        $routeInfo = $this->dispatcher->dispatch(
            $this->request->getMethod(),
            $this->request->get('url')
        );
        switch ($routeInfo[0]) {
            case 0:
                $response = $this->response->create(
                    JsonResponse::class,
                    ['message' => 'Not Found'],
                    Response::HTTP_NOT_FOUND
                );
                break;
            case 2:
                $response = $this->response->create(
                    JsonResponse::class,
                    ['message' => 'The method you\'re using is not allowed for this route'],
                    Response::HTTP_METHOD_NOT_ALLOWED
                );
                break;
            case 1:
                $handler = $routeInfo[1];
                $arguments = $routeInfo[2];
                if ($this->isCallableWithinObject($handler)) {
                    $controller = $this->container->get($handler[0]);
                    $response = $controller->callAction($handler[1], $arguments);
                } else {
                    $response = call_user_func_array($handler, $arguments);
                }
                break;
        }

        return $response->send();
    }

    /**
     * If the given handler is an array, we assume its a pair Controller - Method, so the callable function is inside an object
     * @param $handler
     * @return bool
     */
    private function isCallableWithinObject($handler)
    {
        return is_array($handler);
    }

    /**
     * If theres a method asked to the kernel that its non existing, then we use this magic func to check
     * if theres any service in the container that has the method, and tries to execute it :)
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        foreach ($this->coreServices as $service) {
            $object = $this->{$service};
            if (method_exists($object, $name) && is_callable([$object, $name])) {
                call_user_func_array([$object, $name], $arguments);
            }
        }
    }
}