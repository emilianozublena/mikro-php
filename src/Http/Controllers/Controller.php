<?php
/**
 * Interface for all controllers. Any controller has to implement this interface
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Http\Controllers;

use Mikro\Views\View;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Zend\Stdlib\Exception\BadMethodCallException;

abstract class Controller
{
    protected $container, $request, $view;

    function __construct(ContainerInterface $container, Request $request, View $view)
    {
        $this->container = $container;
        $this->request = $request;
        $this->view = $view;
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string $method
     * @param  array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  array $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function missingMethod($parameters = [])
    {
        throw new BadMethodCallException('Method not found within controller');
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException("Method [{$method}] does not exist.");
    }
}