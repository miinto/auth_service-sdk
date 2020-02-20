<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Response\Decorator;

use \Miinto\AuthService\Sdk\Http\Response\DecoratorInterface;
use \Psr\Http\Message\ResponseInterface;

class Json implements DecoratorInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    public function decorate(ResponseInterface $response): array
    {
        $data = \json_decode((string) $response->getBody(), true);
        if ($data === null) {
            throw new \RuntimeException(
                'Response body has incorrect json format: ' . (string) $response->getBody()
            );
        }

        return $data['data'];
    }
}