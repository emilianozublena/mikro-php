<?php
/**
 * Comments go here
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: ${PACKAGE}
 */

namespace Mikro\Utils;


use Interop\Container\ContainerInterface;

class Url
{
    private $container, $config;

    function __construct(ContainerInterface $container, $config = [])
    {
        $this->container = $container;
        $this->config = $config;
    }

    public function getAssetUrl($subfolder, $file)
    {
        return $this->getAssetsUrl() . $subfolder . '/' . $file;
    }

    private function getAssetsUrl()
    {
        return $this->getFullUrl('resources/assets/');
    }

    public function getFullUrl($relativeUrl = '')
    {
        $baseUrl = $this->config['baseUrl'];
        if(!preg_match('/\/$/', $baseUrl)) {
            $baseUrl .= '/';
        }
        if(preg_match('/^\//', $relativeUrl)) {
            $relativeUrl = substr($relativeUrl, 1, strlen($relativeUrl));
        }
        return  $baseUrl . $relativeUrl;
    }
}