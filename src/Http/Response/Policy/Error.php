<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Response\Policy;

use \Miinto\AuthService\Sdk\Http\Response\PolicyInterface;
use \Miinto\AuthService\Sdk\Http\Response\Exception;
use \Psr\Http\Message\ResponseInterface;

class Error implements PolicyInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function handle(ResponseInterface $response): ResponseInterface
    {
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) {
            throw new Exception(
                [
                    'code' => $response->getStatusCode(),
                    'reasonPhrase' => $response->getReasonPhrase(),
                    'body' => $response->getBody()->getContents(),
                    'headers' => $response->getHeaders()
                ],
                'Invalid http response: '. $response->getStatusCode(). ' ' .$response->getReasonPhrase(),
            );
        }

        return $response;
    }
}