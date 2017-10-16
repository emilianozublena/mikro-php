<?php
/**
 * Tests for Response object
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Tests;

use Mikro\Http\Response as MikroResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider responseProvider
     * @param $provider
     */
    public function testCreateReturnsResponseObject($provider)
    {
        $response = new MikroResponse();
        $finalObject = $response->create($provider['response'], $provider['content'], $provider['status']);
        $this->assertTrue(
            $finalObject instanceof \Symfony\Component\HttpFoundation\Response
        );
    }

    public function responseProvider()
    {
        return [
            [
                [
                    'response' => JsonResponse::class,
                    'content'  => ['message' => 'Example'],
                    'status'   => Response::HTTP_NOT_FOUND
                ]
            ]
        ];
    }
}