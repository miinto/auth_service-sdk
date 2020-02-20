<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Response;

use \Psr\Http\Message\ResponseInterface;

interface PolicyInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function handle(ResponseInterface $response): ResponseInterface;
}