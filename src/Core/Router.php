<?php
/**
 * Simple class to add route elements to an array, this object is later used by kernel with FastRoute to put together routes of the app
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Core;


class Router
{
    private $routes;

    public function getRoutes()
    {
        return $this->routes;
    }

    private function add($httpMethod, $route, $handler)
    {
        $this->routes[] = [
            'httpMethod' => $httpMethod,
            'route'      => $route,
            'handler'    => $handler
        ];
    }

    public function get($route, $handler)
    {
        $this->add('get', $route, $handler);
    }

    public function post($route, $handler)
    {
        $this->add('post', $route, $handler);
    }

    public function delete($route, $handler)
    {
        $this->add('delete', $route, $handler);
    }

    public function put($route, $handler)
    {
        $this->add('put', $route, $handler);
    }

    public function patch($route, $handler)
    {
        $this->add('patch', $route, $handler);
    }

    public function match($method, $route, $handler)
    {
        $this->add($method, $route, $handler);
    }
}