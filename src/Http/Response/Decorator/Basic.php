<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Response\Decorator;

use \Miinto\AuthService\Sdk\Http\Response\DecoratorInterface;
use \Psr\Http\Message\ResponseInterface;

class Basic implements DecoratorInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function decorate(ResponseInterface $response): ResponseInterface
    {
        return $response;
    }
}