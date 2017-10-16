<?php
/**
 * Tests for Kernel object
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Tests;


use Interop\Container\ContainerInterface;

class KernelTest extends \PHPUnit_Framework_TestCase
{
    public function testGetContainerRetrievesValidServiceManager() {
        $container = (require 'src/config/services.php');
        $kernel = $container->get('kernel');
        $kernel->initCore();
        $this->assertTrue($kernel->getContainer() instanceof ContainerInterface);
    }

    public function testProcessRoutesSetsAValidDispatcher(){
        $container = (require 'src/config/services.php');
        $kernel = $container->get('kernel');
        $kernel->initCore();
        require 'src/config/routes.php';
        $kernel->processRoutes();
        $this->assertTrue($kernel->getDispatcher() instanceof \FastRoute\Dispatcher\GroupCountBased);
    }
}