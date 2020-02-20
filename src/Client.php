<?php

declare (strict_types=1);

namespace Miinto\AuthService\Sdk;

use \Miinto\ApiClient\Client as MiintoClient;
use \Miinto\ApiClient\Request\Factory as RequestFactory;
use \Miinto\ApiClient\Response\Decoder\Json as JsonDecoder;
use \Miinto\AuthService\Sdk\Dto\Factory as DtoFactory;
use \Miinto\AuthService\Sdk\Dto\Mapper\FromArray\Channel as ChannelMapper;

class Client
{
    /** @var string  */
    protected $url;

    /** @var DtoFactory */
    protected $dtoFactory;

    /** @var MiintoClient */
    protected $httpClient;

    /** @var RequestFactory  */
    protected $requestFactory;

    /**
     * AuthService constructor.
     *
     * @param MiintoClient $httpClient
     * @param  $dtoFactory
     */
    public function __construct(
        string $url,
        MiintoClient $httpClient,
        RequestFactory $requestFactory,
        DtoFactory $dtoFactory
    ) {
        $this->url = $url;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->dtoFactory = $dtoFactory;
    }

    /**
     * Check if api app works fine
     *
     * @GET /status
     *
     * @return array
     *
     * @throws \Miinto\ApiClient\Response\Exception
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function status(): array
    {
        $request = $this->requestFactory->get($this->url . '/status');
        $responseData = JsonDecoder::decode($this->httpClient->sendRequest($request));

        return $responseData['data'];
    }

    /**
     * @POST /channels
     *
     * @param string $identifier
     * @param string $secret
     *
     * @return Dto\Channel
     *
     * @throws \Miinto\ApiClient\Response\Exception
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function createChannel(string $identifier, string $secret): Dto\Channel
    {
        $request = $this->requestFactory->post($this->url . '/channels', [], [
            'identifier' => $identifier,
            'secret' => $secret
        ]);

        $responseData = JsonDecoder::decode($this->httpClient->sendRequest($request));

        return ChannelMapper::map($responseData['data'], $this->dtoFactory);
    }

    /**
     * @POST /channels
     *
     * @param string $channelId
     *
     * @return Dto\Channel
     *
     * @throws \Miinto\ApiClient\Response\Exception
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getChannel(string $channelId): Dto\Channel
    {
        $request = $this->requestFactory->get($this->url . '/channels/' . $channelId);
        $responseData = JsonDecoder::decode($this->httpClient->sendRequest($request));

        return ChannelMapper::map($responseData['data'], $this->dtoFactory);
    }
}