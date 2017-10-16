<?php
/**
 * This factory creates a ServerRequest object from PHP's GLOBALS ($_SERVER, etc)
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Utils\Factories;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Symfony\Component\HttpFoundation\Request;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ServerRequestFactory implements FactoryInterface
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
        $requestFromGlobals = Request::createFromGlobals();
        $getBag = $this->parseRequestedUriForExtraQueryParams($requestFromGlobals);
        $jsonPhpInput = file_get_contents("php://input");
        $request =  new Request(
            $getBag,
            is_array(json_decode($jsonPhpInput, true)) ? json_decode($jsonPhpInput, true) : $_POST,
            $_REQUEST,
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
        return $request;
    }

    private function parseRequestedUriForExtraQueryParams(Request $request)
    {
        $requestedUri = $request->getRequestUri();
        $arUri = explode('?', $requestedUri);
        $getBag = $_GET;
        if(count($arUri)>1) {
            $extraQueryParams = $arUri[1];
            $arExtra = explode('&', $extraQueryParams);
            foreach($arExtra as $queryParam) {
                $param = explode('=', $queryParam);
                $getBag[$param[0]] = $param[1];
            }
        }

        return $getBag;
    }
}