<?php
/**
 * This class works as a wrapper for the Response class of Symfony's HttpFoundation component
 * It initialy servers as a Factory for the different Response's of HttpFoundation
 * Available should be:
 * JsonResponse
 * TextResponse
 * HtmlResponse
 * EmptyResponse
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Http;


class Response
{
    /**
     * This works as a factory for creating specific instances of Response's like JsonResponse, HtmlResponse and such
     * @param $type
     * @param $content
     * @param $httpStatusCode
     * @param array $headers
     * @return mixed
     */
    public function create($type, $content, $httpStatusCode, $headers = [])
    {
        return new $type($content, $httpStatusCode, $headers);
    }
}