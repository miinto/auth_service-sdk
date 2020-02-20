<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Response;

use \Psr\Http\Message\ResponseInterface;

interface DecoratorInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    public function decorate(ResponseInterface $response);
}