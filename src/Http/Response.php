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
    public function create($type, $content, $httpStatusCode, $headers = [])
    {
        return new $type($content, $httpStatusCode, $headers);
    }
}