<?php
/**
 * This object is used when you want to return a View after a request's been made.
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Views;


use Interop\Container\ContainerInterface;
use Mikro\Utils\Url;
use Symfony\Component\HttpFoundation\Response;

class View
{
    private $container, $content, $file, $url;

    function __construct(ContainerInterface $container, Url $url)
    {
        $this->container = $container;
        $this->url = $url;
    }


    /**
     * This function should use a parser to give this object Templating powers
     * @return $this
     */
    public function parse()
    {
        return $this;
    }

    /**
     * Loads the view file requested. The path received is assumed to be relative to resources/views path
     * @param $file
     * @return $this
     */
    public function file($file)
    {
        if (preg_match('/\.php/', $file)) {
            $this->file = realpath('./resources/views/' . $file);
        } else {
            $this->file = realpath('./resources/views/' . $file . '.php');
        }
        return $this;
    }

    /**
     * Here is where the actual view gets rendered.
     * @param array $params
     * @return $this
     */
    public function render($params = [])
    {
        ob_start();
        //extract everything in params into the current scope
        extract($params, EXTR_SKIP);
        include $this->file;
        $ret = ob_get_contents();
        $this->content = $ret;
        ob_end_clean();
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns a valid Response object FROM the content that the view has
     * @return Response
     */
    public function getResponse()
    {
        return new Response(
            $this->content,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
    }

    public function asset($subfolder, $file)
    {
        return $this->url->getAssetUrl($subfolder, $file);
    }

    public function url($relativeUrl = '')
    {
        return $this->url->getFullUrl($relativeUrl);
    }
}