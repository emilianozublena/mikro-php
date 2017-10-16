<?php
/**
 * This is an example Home Controller
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Home extends Controller
{
    public function index(){
        $view = $this->container->get('view');

        return $view->file('book')->render([
            'hola' => 'chau'
        ])->getResponse();
    }
}