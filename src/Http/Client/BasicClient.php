<?php

declare(strict_types=1);

namespace Miinto\AuthService\Sdk\Http\Client;

use \Psr\Http\Client\ClientInterface as PsrClientInterface;
use \Psr\Http\Message\ServerRequestFactoryInterface;
use \Miinto\AuthService\Sdk\Http\Request\SignerInterface;
use \Miinto\AuthService\Sdk\Http\Response\DecoratorInterface;
use \Miinto\AuthService\Sdk\Http\Response\PolicyInterface;
use \Miinto\AuthService\Sdk\Dto\Credential;
use \Phalcon\Http\Message\Stream;
use \Phalcon\Http\Message\ServerRequest;

class BasicClient implements ClientInterface
{
    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';

    /** @var string */
    protected $urlToApi;

    /** @var PsrClientInterface */
    protected $httpClient;

    /** @var ServerRequestFactoryInterface */
    protected $requestFactory;

    /** @var SignerInterface */
    protected $requestSigner;

    /** @var DecoratorInterface */
    protected $responseDecorator;

    /** @var PolicyInterface */
    protected $responseErrorPolicy;

    /**
     * BasicClient constructor.
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
    ) {
        $this->urlToApi = $urlToApi;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->requestSigner = $requestSigner;
        $this->responseDecorator = $responseDecorator;
        $this->responseErrorPolicy = $responseErrorPolicy;
    }

    /**
     * @param string $path
     * @param Credential|null $credential
     * @param array $queryData
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @return mixed
     */
    public function get(
        string $path,
        Credential $credential = null,
        array $queryData = []
    ) {

        if (\count($queryData) > 0) {
            $path .= '?' . \http_build_query($queryData);
        }

        return $this->sendRequest(static::HTTP_METHOD_GET, $path, [], $credential);
    }

    /**
     * @param string $path
     * @param Credential|null $credential
     * @param array $postData
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @return mixed
     */
    public function post(
        string $path,
        Credential $credential = null,
        array $postData = []
    ) {
        return $this->sendRequest(static::HTTP_METHOD_POST, $path, $postData, $credential);
    }

    /**
     * @param string $httpMethod
     * @param string $url
     * @param array $postData
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendRequest(
        string $httpMethod,
        string $url,
        $postData = [],
        Credential $credential = null
    ): array {
        $defaultStream = 'php://input';
        if (\count($postData) > 0) {
            $defaultStream = new Stream('php://memory', 'wb');
            $defaultStream->write(\json_encode($postData));
        }

        $request = new ServerRequest(
            $httpMethod,
            $this->urlToApi . $url,
            [],
            $defaultStream,
            [
                'Content-Type' => 'application/json',
            ]
        );

        $credential !== null and $request = $this->requestSigner->sign($request, $credential);
        
        return $this->responseDecorator->decorate(
            $this->responseErrorPolicy->handle(
                $this->httpClient->sendRequest($request)
            )
        );
    }

    /**
     * @param DecoratorInterface $decorator
     *
     * @return $this
     */
    public function setResponseDecorator(DecoratorInterface $decorator): self
    {
        $this->responseDecorator = $decorator;

        return $this;
    }

    /**
     * @param PolicyInterface $policy
     *
     * @return $this
     */
    public function setResponsePolicy(PolicyInterface $policy): self
    {
        $this->responseErrorPolicy = $policy;

        return $this;
    }
}