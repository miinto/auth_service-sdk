<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Client;

use \Psr\Http\Client\ClientInterface as PsrClientInterface;
use \Psr\Http\Message\ServerRequestFactoryInterface;
use \Miinto\AuthService\Sdk\Http\Request\Signer;
use \Miinto\AuthService\Sdk\Http\Response\Decorator\Json;
use \Miinto\AuthService\Sdk\Http\Response\Policy\Error;

class Factory
{
    /**
     * @param string $urlToApi
     * @param PsrClientInterface $httpClient
     * @param ServerRequestFactoryInterface $requestFactory
     *
     * @return BasicClient
     */
    public static function createBasicClient(
        string $urlToApi,
        PsrClientInterface $httpClient,
        ServerRequestFactoryInterface $requestFactory
    ): BasicClient {
        $requestSigner = new Signer();
        $responseDecorator = new Json();
        $responsePolicy = new Error();

        return new BasicClient(
            $urlToApi,
            $httpClient,
            $requestFactory,
            $requestSigner,
            $responseDecorator,
            $responsePolicy
        );
    }
}