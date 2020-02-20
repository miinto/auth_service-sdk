<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Client;

use \Psr\Http\Client\ClientInterface as PsrClientInterface;
use \Psr\Http\Message\ServerRequestFactoryInterface;
use \Miinto\AuthService\Sdk\Http\Request\SignerInterface;
use \Miinto\AuthService\Sdk\Http\Response\DecoratorInterface;
use \Miinto\AuthService\Sdk\Http\Response\PolicyInterface;
use \Miinto\AuthService\Sdk\Dto\Credential;

interface ClientInterface
{
    /**
     * ClientInterface constructor.
     *
     * @param string $urlToApi
     * @param PsrClientInterface $httpClient
     * @param ServerRequestFactoryInterface $requestFactory
     * @param SignerInterface $requestSigner
     * @param DecoratorInterface $responseDecorator
     * @param PolicyInterface $responseErrorPolicy
     */
    public function __construct(
        string $urlToApi,
        PsrClientInterface $httpClient,
        ServerRequestFactoryInterface $requestFactory,
        SignerInterface $requestSigner,
        DecoratorInterface $responseDecorator,
        PolicyInterface $responseErrorPolicy
    );

    /**
     * @param string $path
     * @param Credential|null $credential
     * @param array $queryData
     *
     * @return mixed
     */
    public function get(
        string $path,
        Credential $credential = null,
        array $queryData = []
    );

    /**
     * @param string $path
     * @param Credential|null $credential
     * @param array $postData
     *
     * @return mixed
     */
    public function post(
        string $path,
        Credential $credential = null,
        array $postData = []
    );
}